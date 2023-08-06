<?php

namespace common\models;

use yii\base\Model;

class UserForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Такой email уже используется.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function getUserAttributes()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}