<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserDB extends ActiveRecord
{
    public static function tableName()
        {
            return "user";
        }
}