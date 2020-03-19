<?php

namespace app\models;


use yii\db\ActiveRecord;

class CitizenDB extends ActiveRecord
{
    public static function tableName()
    {
        return "civilian";
    }
}