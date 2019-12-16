<?php

namespace app\models;

use yii\db\ActiveRecord;

class RegistrationSitizen extends ActiveRecord
{
    public static function tableName()
        {
            return "user";
        }
}