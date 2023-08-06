<?php

namespace backend\services\EmailServices;

use common\models\User;
use backend\jobs\SendWelcomeEmailJob;
use yii\web\Response;
use Yii;

class RegisterService extends \backend\services\BaseService
{

    public function actionRegister($postData)
    {
        $user = new User();
        $user->username = $postData['username'];
        $user->email = $postData['email'];
        $user->password_hash = Yii::$app->security->generatePasswordHash($postData['password']);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            
            try {
                Yii::$app->queue->push(new SendWelcomeEmailJob(['user_id' => $user->id]));
            } catch (\Exception $e) {
                Yii::error('Произошла ошибка при добавлении задачи в очередь: ' . $e->getMessage(), 'send-email');
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'success', 'message' => 'Регистрация прошла успешно. Письмо будет отправлено на ваш email.'];
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => 'error', 'message' => 'Ошибка при регистрации пользователя. Пожалуйста, проверьте введенные данные.'];
        }
    }
}