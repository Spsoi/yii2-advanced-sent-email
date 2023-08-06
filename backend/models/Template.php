<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property int $mailer_id
 * @property int $lang_id
 * @property string $name
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property AppTemplate[] $appTemplates
 * @property App[] $apps
 * @property Lang $lang
 * @property Mailer $mailer
 * @property SentEmails[] $sentEmails
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mailer_id', 'lang_id', 'name'], 'required'],
            [['mailer_id', 'lang_id'], 'integer'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'subject'], 'string', 'max' => 255],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['lang_id' => 'id']],
            [['mailer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mailer::class, 'targetAttribute' => ['mailer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mailer_id' => 'Mailer ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'subject' => 'Subject',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[AppTemplates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppTemplates()
    {
        return $this->hasMany(AppTemplate::class, ['template_id' => 'id']);
    }

    /**
     * Gets query for [[Apps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApps()
    {
        return $this->hasMany(App::class, ['id' => 'app_id'])->viaTable('app_template', ['template_id' => 'id']);
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::class, ['id' => 'lang_id']);
    }

    /**
     * Gets query for [[Mailer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMailer()
    {
        return $this->hasOne(Mailer::class, ['id' => 'mailer_id']);
    }

    /**
     * Gets query for [[SentEmails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSentEmails()
    {
        return $this->hasMany(SentEmails::class, ['template_id' => 'id']);
    }
}
