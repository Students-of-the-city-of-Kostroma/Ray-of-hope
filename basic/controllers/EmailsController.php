<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Emails;

class EmailsController extends Controller
{
    public function actionIndex()
    {
        $query = Emails::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $emails = $query->orderBy('id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'emails' => $emails,
            'pag' => $pagination,
        ]);
    }
}
