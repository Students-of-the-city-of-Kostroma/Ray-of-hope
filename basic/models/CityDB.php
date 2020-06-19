<?php

namespace app\models;


use yii\db\ActiveRecord;

class CityDB extends ActiveRecord
{
    public static function tableName()
    {
        return "city";
    }
}