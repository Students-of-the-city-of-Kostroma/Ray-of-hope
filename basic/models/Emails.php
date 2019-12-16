<?php

namespace app\models;

use yii\db\ActiveRecord;

class Emails extends ActiveRecord
{
    public static function tableName()
    {
        return "email";
    }
}