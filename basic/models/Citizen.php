<?php

namespace app\models;

use yii\base\Model;

class Citizen extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['name','email', 'password', 'password_repeat' ], 'required'],
            ['email', 'email'],
            ['password', 'string', 'length' => [8, 32]],
            ['password',  'compare'],            
        ];
    }
}