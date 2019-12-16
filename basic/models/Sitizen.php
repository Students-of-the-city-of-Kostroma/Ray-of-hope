<?php

namespace app\models;

use yii\base\Model;

class Sitizen extends Model
{
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat' ], 'required'],
            ['email', 'email'],
            ['password',  'compare'],
            ['password', 'string', 'length' => [4, 24]],
        ];
    }
}