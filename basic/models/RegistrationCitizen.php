<?php

namespace app\models;

use yii\db\ActiveRecord;

class RegistrationCitizen extends ActiveRecord
{
    public static function tableName()
        {
            return "user";
        }
}