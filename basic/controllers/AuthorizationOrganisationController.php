<?php

namespace app\controllers;

use app\models\EmailDB;
use app\models\UserDB;
use app\models\OrganisationDB;
use yii\web\Controller;
use app\models\OrganisationAuthorization;
use Yii;


class AuthorizationOrganisationController extends Controller
{

    public $layout = 'outside';


     // public function actionIndex()
     // {
     //     return $this ->render('../registration/registration-citizen');
    // }

    public function actionProfile()
    {
        // do some session

        return $this->render('succesfuly');


        # return $this ->render('../registration/registration-citizen');
    }


    public function actionCreate()
    {
        
        $request = Yii::$app->request;

        

        $organisationInputToValidate =  new OrganisationAuthorization();

       
        // заполняем модель данными из запроса
        // $organisationInputToValidate->attributes = $request->post();

        

        $organisationInputToValidate->emailOrInn = $request->post('email_or_inn');
        $organisationInputToValidate->password = $request->post('password');


        // формируем массив для ответов
        $resolveToUser = [
            'newUrl' => null,
            'errors' => [
                'isEmpty' => false,
                'isCorrect' => false,            
            ],

        ];
        
        

        // если модель валидна
        if ($organisationInputToValidate->validate()) {
        

            $check = [];

            if (strripos($organisationInputToValidate->emailOrInn, "@") === FALSE) {

                $INN = $organisationInputToValidate->emailOrInn;
                $name = "user_id";

                $check = OrganisationDB::find()
                    ->where(['INN' => $organisationInputToValidate->emailOrInn])                                       
                    ->all();                           
            }

            else {              

                $email = $organisationInputToValidate->emailOrInn;
                $name = "id";

                $check = EmailDB::find()
                    ->where(['email' => $organisationInputToValidate->emailOrInn])                                
                    ->all();                            
            }                     

                               
            if (count($check) !== 0) {

                $passCheck = UserDB::find()
                    ->where(['email' => $check[0][$name]])
                    ->all();

                $passCheckInput = md5($organisationInputToValidate->password);

                if ($passCheckInput !== $passCheck[0]["password"]) {
                    $resolveToUser['errors']['isCorrect'] = true;
                }
                
            }

            else {
                $resolveToUser['errors']['isCorrect'] = true;
            }
        }



        // модель не валидна
        else {
                        
            $errors = $organisationInputToValidate->errors;

            $f = false;
                foreach ($errors as $value){
                    if (strripos($value[0], 'blank') !== false)
                        $f = true;
                }    
                
            if ($f){
                $resolveToUser['errors']['isEmpty'] = true;
            }
            else {
                $resolveToUser['errors']['isCorrect'] = true;
            }
            
        }
            
        // {

        //     $errors = $organisationInputToValidate->errors;

        //     /**
        //      * Типы ошибок в последовательности
        //      *
        //      * Заполните все поля
        //      * Возникает когда хоть в одном есть слово blank
        //      * email password password_repeat name
        //      * isEmpty = true
        //      *
        //      * Неверно указан логин или пароль
        //      * Свойство email это "Email is not a valid email address." или свойство password это "Password should contain at least 6 characters."
        //      * isCorrect = true             
        //      */

        //     // заполните все поля
        //     $f = false;
        //     foreach ($errors as $value){
        //         if (strripos($value[0], 'blank') !== false)
        //             $f = true;
        //     }


        //     if (!$f){
        //         if (!(array_key_exists('email', $errors))){
        //             if ($errors['password'][0] !== "Password should contain at least 6 characters."){
        //                 $resolveToUser['errors']['isPassEquals'] = true;
        //             }
        //             else {
        //                 $resolveToUser['errors']['isPassCorrected'] = true;
        //             }
        //         }
        //         else {
        //             $resolveToUser['errors']['isEmailCorrected'] = true;
        //         }
        //     }
        //     else {
        //         $resolveToUser['errors']['isEmpty'] = true;
        //     }

        // }

        if ($resolveToUser['errors']['isCorrect'] === false and $resolveToUser['errors']['isEmpty'] === false)
            $resolveToUser['newUrl'] = "/index.php?r=authorization-organisation%2Fprofile";

        $json = json_encode($resolveToUser);
        
        return $json;

    }

}
