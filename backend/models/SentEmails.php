<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sent_emails".
 *
 * @property int $id
 * @property int $template_id
 * @property string $recipient_email
 * @property string|null $recipient_name
 * @property string|null $sent_at
 * @property string|null $delivered_at
 * @property string $delivery_status
 * @property string|null $delivery_response
 * @property string|null $error_message
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Template $template
 */
class SentEmails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sent_emails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_id', 'recipient_email'], 'required'],
            [['template_id'], 'integer'],
            [['sent_at', 'delivered_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['delivery_status'], 'string'],
            [['recipient_email', 'recipient_name', 'delivery_response', 'error_message'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'recipient_email' => 'Recipient Email',
            'recipient_name' => 'Recipient Name',
            'sent_at' => 'Sent At',
            'delivered_at' => 'Delivered At',
            'delivery_status' => 'Delivery Status',
            'delivery_response' => 'Delivery Response',
            'error_message' => 'Error Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Template]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }
}
