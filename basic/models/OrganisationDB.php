<?php

namespace app\models;


use yii\db\ActiveRecord;

class OrganisationDB extends ActiveRecord
{
    public static function tableName()
    {
        return "organization";
    }
}