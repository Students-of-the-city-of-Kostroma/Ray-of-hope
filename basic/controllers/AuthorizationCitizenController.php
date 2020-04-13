<?php

namespace app\controllers;

use app\models\EmailDB;
use app\models\UserDB;
use yii\web\Controller;
use app\models\Citizen;
use Yii;


class AuthorizationCitizenController extends Controller
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

        $citizenInputToValidate =  new Citizen();

        // заполняем модель данными из запроса
        // $citizenInputToValidate->attributes = $request->post();

        $citizenInputToValidate->name = "";
        $citizenInputToValidate->email = $request->post('email');
        $citizenInputToValidate->password = $request->post('password');
        $citizenInputToValidate->password_repeat = $request->post('password');

        // формируем массив для ответов
        $resolveToUser = [
            'newUrl' => null,
            'errors' => [
                'isEmpty' => false,
                'isCorrect' => false,            
            ],

        ];


        
        // если модель валидна
        if ($citizenInputToValidate->validate()) {

            // ищем, есть ли нужный нам email
            $emailCheck = EmailDB::find()
                ->where(['email' => $citizenInputToValidate->email])
                ->all();
                               
            if (count($emailCheck) !== 0) {

                $passCheck = UserDB::find()
                    ->where(['email' => $emailCheck->id])
                    ->all();

                $passCheckInput = md5($citizenInputToValidate->password);

                if ($passCheckInput === $passCheck["password"]) {
                    $resolveToUser['errors']['isCorrect'] = false;
                }
                                
                else {
                    $resolveToUser['errors']['isCorrect'] = true;
                }
            }

            else {
                $resolveToUser['errors']['isCorrect'] = true;
            }
        }
        // модель не валидна
        else {

            
            $errors = $citizenInputToValidate->errors;

            $f = false;
                foreach ($errors as $value){
                    if (strripos($value[0], 'blank') !== false)
                        $f = true;
                }
            

                
            if ($f){
                $resolveToUs1er['errors']['isEmpty'] = true;
            }
            else {
                $resolveToUser['errors']['isCorrect'] = true;
            }
            
        }
            
        // {

        //     $errors = $citizenInputToValidate->errors;

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
            $resolveToUser['newUrl'] = "/index.php?r=authorization-citizen%2Fprofile";

        $json = json_encode($resolveToUser);
        
        return $json;

    }

}
