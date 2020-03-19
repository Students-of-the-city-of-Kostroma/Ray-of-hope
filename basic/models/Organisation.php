<?php

namespace app\models;

use yii\base\Model;

class Organisation extends Model
{
    public $name;
    public $email;
    public $INN;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['name','email', 'INN', 'password', 'password_repeat' ], 'required'],
            ['email', 'email'],
            ['INN', 'match', 'pattern' => '/\d{10}/'],
            ['password',  'compare'],
            ['password', 'string', 'length' => [6, 32]],
        ];
    }
}