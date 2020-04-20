<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class RegistrationController extends Controller
{
    public $layout = 'outside';

    public function actionCitizen()
    {
        return $this->render('registration-citizen');
    }

    public function actionOrganisation()
    {
        return $this->render('registration-organisation');
    }

}