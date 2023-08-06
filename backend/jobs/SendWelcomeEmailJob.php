<?php

namespace backend\jobs;

use backend\models\SentEmails; // Подключаем модель Mailer
use yii\base\BaseObject;
use Yii;

class SendWelcomeEmailJob extends BaseObject implements \yii\queue\JobInterface
{
    public $user_id;

    public function execute($queue)
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            $user = \common\models\User::findOne($this->user_id);

            // Template::find() // NOTE не выдаёт нужные поля
            // 
            //     ->select([
            //         'template.id',
            //         'template.subject',
            //         'template.body',
            //         'mailer.scheme AS mailer_scheme',
            //         'mailer.dsn AS mailer_dsn',
            //         'mailer.name AS mailer_name',
            //         'mailer.host AS mailer_host',
            //         'mailer.port AS mailer_port',
            //         'mailer.username AS mailer_username',
            //         'mailer.password AS mailer_password',
            //         'mailer.encryption AS mailer_encryption',
            //         'lang.code AS lang_code',
            //         'lang.name AS lang_name',
            //         'app.name AS app_name',
            //         'app.description AS app_description',
            //     ])
            // 
            //     ->leftJoin('mailer', 'template.mailer_id = mailer.id')
            //     ->leftJoin('lang', 'template.lang_id = lang.id')
            //     ->leftJoin('app_template', 'template.id = app_template.template_id')
            //     ->leftJoin('app', 'app_template.app_id = app.id')
            //     ->where(['template.name' => 'registration_email', 'mailer.is_active' => 1])
            //     ->one();
      
            $command = Yii::$app->db->createCommand('
                SELECT
                    template.*,
                    mailer.scheme AS mailer_scheme,
                    mailer.dsn AS mailer_dsn,
                    mailer.name AS mailer_name,
                    mailer.host AS mailer_host,
                    mailer.port AS mailer_port,
                    mailer.username AS mailer_username,
                    mailer.password AS mailer_password,
                    mailer.encryption AS mailer_encryption,
                    lang.code AS lang_code,
                    lang.name AS lang_name,
                    app.name AS app_name,
                    app.description AS app_description
                FROM template
                LEFT JOIN mailer ON template.mailer_id = mailer.id
                LEFT JOIN lang ON template.lang_id = lang.id
                LEFT JOIN app_template ON template.id = app_template.template_id
                LEFT JOIN app ON app_template.app_id = app.id
                WHERE template.name = :templateName AND mailer.is_active = :mailerIsActive
                    ', [
                        ':templateName' => 'registration_email',
                        ':mailerIsActive' => 1
                    ]
            );

            $rows = $command->queryAll();
            $templateData = reset($rows);

            if (empty($templateData)) {
                throw new \Exception('Template not found.');
            }

            $sentEmail = new SentEmails();
            $sentEmail->template_id = $templateData['id'];
            $sentEmail->recipient_email = $user->email;
            $sentEmail->recipient_name = $user->username;

            if (!$sentEmail->save()) {
                Yii::error('Ошибка при сохранении шаблона письма в базу данных: ', 'send-email');
                throw new \Exception('Failed to save SentEmails.');
            }

            $symfonyMailer = Yii::$app->mailer;
            $sentEmail->sent_at = date('Y-m-d H:i:s');

            $send = $symfonyMailer->compose()
                ->setTo($user->email)
                ->setFrom(['admin@example1.com' => 'Admin'])
                ->setSubject($templateData['subject'])
                ->setTextBody(str_replace('{username}', $user->username, $templateData['body']))
                ->send();
            
            if (!empty($send)) {
                $sentEmail->delivered_at = date('Y-m-d H:i:s');
                $sentEmail->delivery_status = 'delivered';
                $sentEmail->delivery_response = '250';
            } else {
                $sentEmail->delivery_status = 'failed';
                $sentEmail->delivery_response = '500';
                $sentEmail->error_message = 'error sent email';
            }
        
            if (!$sentEmail->save()) {
                Yii::error('Ошибка при сохранении ответа в базу данных: ', 'send-email');
                throw new \Exception('Failed to save response SentEmails.');
            }

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            Yii::error('Ошибка при работе с базой данных: ' . $e->getMessage(), 'send-email');
            $transaction->rollBack();
        } catch (\Exception $e) {
            Yii::error('Произошла неизвестная ошибка: ' . $e->getMessage(), 'send-email');
            $transaction->rollBack();
        }
    } 
}