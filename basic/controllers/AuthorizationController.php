<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

class AuthorizationController extends Controller
{
    public $layout = 'outside';

    public function actionCitizen()
    {
        return $this->render('authorization-citizen');
    }

    public function actionOrganisation()
    {
        return $this->render('authorization-organisation');
    }

}