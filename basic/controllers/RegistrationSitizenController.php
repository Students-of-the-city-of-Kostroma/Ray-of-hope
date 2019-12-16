<?php

namespace app\controllers;

use app\models\Emails;
use yii\web\Controller;
use app\models\Sitizen;
use app\models\RegistrationSitizen;
use Yii;


class RegistrationSitizenController extends Controller
{
    public function actionIndex()
    {
        $model = new Sitizen();

        if ($model -> load(Yii::$app->request->post()) && $model -> validate()){

            # do some useful code
            $emailCheck = Emails::find()
                ->where(['email' => $model->email])
                ->all();

//            $query = RegistrationSitizen::find()
//                ->where(['email' => $emailCheck->id])
//                ->where(['password' => $model->password])
//                ->all();

            if (count($emailCheck) == 0)
            {
                $newSitizenInfo = new Emails();

                $newSitizenInfo->email = $model->email;

                $newSitizenInfo->hash = md5($model->password);

                $newSitizenInfo->save();

                $newSitizen = new RegistrationSitizen();

                $newSitizen->email = $newSitizenInfo->id;
                $newSitizen->password = $model->password;
                $newSitizen->type_of_account = 1;
                $newSitizen->save();

                return $this->render('succesfuly', ['model' => $model]);
            }

            # end of doing some useful code

            return $this->render('unsuccesfuly', ['model' => $model]);
        }
        else
        {
            return $this ->render('unposted', ['model' => $model]);
        }
    }
}