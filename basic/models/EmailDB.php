<?php

namespace app\models;


use yii\db\ActiveRecord;

class EmailDB extends ActiveRecord
{
    public static function tableName()
    {
        return "email";
    }
}