<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use Yii;

class ForgotPasswordController extends Controller
{
    public $layout = 'outside';

    public function actionIndex()
    {    
        return $this->render('index');
    }
}
