<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mailer".
 *
 * @property int $id
 * @property string $name
 * @property string $host
 * @property int $port
 * @property string $username
 * @property string $password
 * @property string|null $encryption
 * @property int|null $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Template[] $templates
 */
class Mailer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'host', 'port', 'username', 'password'], 'required'],
            [['port', 'is_active'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'host', 'username', 'password', 'encryption'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'host' => 'Host',
            'port' => 'Port',
            'username' => 'Username',
            'password' => 'Password',
            'encryption' => 'Encryption',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Templates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::class, ['mailer_id' => 'id']);
    }
}
