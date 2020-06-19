<?php

namespace app\models;

use yii\base\Model;

class OrganisationEdit extends Model
{
    public $address;
    public $city;
    public $INN;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['name','email', 'INN', 'password', 'password_repeat' ], 'required'],
            ['email', 'email'],
            ['name', 'string', 'length' => [1, 255]],
            ['INN', 'string', 'length' => 10],
            ['INN', 'match', 'pattern' => '/\d{10}/'],
            ['password', 'string', 'length' => [8, 32]],
            ['password',  'match', 'pattern' => '/^[a-z0-9]\w*$/i'],
            ['password',  'compare'],        
        ];
    }
}