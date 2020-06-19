<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;


class SessionController extends Controller
{
    public function actionDestroy()
    {
        Yii::$app->session->destroy();
        return  Yii::$app->response->redirect("/");
    }


}