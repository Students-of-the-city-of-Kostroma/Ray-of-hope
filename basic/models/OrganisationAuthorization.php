<?php

namespace app\models;

use yii\base\Model;

class OrganisationAuthorization extends Model
{
    public $emailOrInn;
    public $password;

    public function rules()
    {
        return [
            [['password', 'emailOrInn'], 'required'],            

            ['emailOrInn', 'email', 'when' => function($model) {
                return (preg_match('/\d{10}/', $model->emailOrInn) !== 1 or strlen($model->emailOrInn) !== 10);
            } ],

            #['INN', 'match', 'pattern' => '/\d{10}/'],    
            ['password', 'string', 'length' => [6, 32]],
        ];
    }
}