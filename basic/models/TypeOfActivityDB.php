<?php

namespace app\models;


use yii\db\ActiveRecord;

class TypeOfActivityDB extends ActiveRecord
{
    public static function tableName()
    {
        return "type_of_activity";
    }
}