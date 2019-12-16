<?php

namespace app\controllers;

use app\models\Emails;
use yii\web\Controller;
use app\models\Citizen;
use app\models\RegistrationCitizen;
use Yii;


class RegistrationCitizenController extends Controller
{

    public $layout = 'outside';


    public function actionIndex()
    {
        return $this ->render('../registration/registration-citizen');
    }

    public function actionCreate()
    {
# echo 111;die();


        ?>
        <script>console.log('2')</script>
        <?php


        $request = Yii::$app->request;
        $model =  new Citizen();


        $model->name = $request->post('name');
        $model->email = $request->post('email');
        $model->password = $request->post('password');
        $model->password_repeat = $request->post('password');


        ?>
        <script>
            console.log("<?= $model->name; ?>" );
            console.log("<?= $model->email; ?>");
            console.log("<?= $model->password; ?>" );
        </script>
        <?php

        if ($model -> validate()){

            ?>
            <script>console.log('2')</script>
            <?php

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

                $newSitizen = new RegistrationCitizen();

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
            //header('Location: /index.php?r=registration%2Fcitizen');
            # return $this ->render('../registration/registration-citizen');
            return Yii::$app->response->redirect(['registration/citizen']);
        }
    }
}
