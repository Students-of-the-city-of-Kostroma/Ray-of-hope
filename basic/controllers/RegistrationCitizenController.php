<?php

namespace app\controllers;

use app\models\EmailDB;
use app\models\UserDB;
use app\models\CitizenDB;
use yii\web\Controller;
use app\models\Citizen;
use Yii;


class RegistrationCitizenController extends Controller
{

    public $layout = 'outside';


    // public function actionIndex()
    // {
    //     return $this ->render('../registration/registration-citizen');
    // }

    // public function actionProfile()
    // {
    //     // do some session

    //     return $this->render('succesfuly');


    //     # return $this ->render('../registration/registration-citizen');
    // }


    public function actionCreate()
    {
        $request = Yii::$app->request;

        $citizenInputToValidate =  new Citizen();

        // заполняем модель данными из запроса
        // $citizenInputToValidate->attributes = $request->post();

        $citizenInputToValidate->name = $request->post('name');
        $citizenInputToValidate->email = $request->post('email');
        $citizenInputToValidate->password = $request->post('password');
        $citizenInputToValidate->password_repeat = $request->post('password_2');

        // формируем массив для ответов
        $resolveToUser = [
            'newUrl' => null,
            'errors' => [
                'isEmpty' => false,
                'isEmailCorrected' => false,
                'isPassCorrected' => false,
                'isPassEqual' => false,
                'isRegistered' => false,
            ],

        ];

        // если модель валидна
        if ($citizenInputToValidate->validate()) {

            // ищем, есть ли нужный нам email
            $emailCheck = EmailDB::find()
                ->where(['email' => $citizenInputToValidate->email])
                ->all();

            // если email не найден -- можно продолжать регаться
            if (count($emailCheck) === 0) {

                $newCitizenEmail = new EmailDB();

                $newCitizenEmail->email = $citizenInputToValidate->email;

                $hashToEmail = md5($citizenInputToValidate->email);

                $newCitizenEmail->hash = $hashToEmail;

                // отправляем письмо с hash для регистрации

                $newCitizenEmail->save();

                $newCitizenAllInfo = new UserDB();

                $newCitizenAllInfo->email = $newCitizenEmail->id;
                $newCitizenAllInfo->password = md5($citizenInputToValidate->password);
                $newCitizenAllInfo->type_of_account = 1;

                $newCitizenAllInfo->save();

                $newCitizen = new CitizenDB();
                
                $newCitizen->user = $newCitizenAllInfo->id;
                $newCitizen->name = $citizenInputToValidate->name;

                $newCitizen->save();

                //$json = $this->formatJson( false, true, false, "/index.php?r=registration-citizen%2Fprofile");

                // перенаправляем на нужную страницу
                $email = $citizenInputToValidate->email;

                $name = $citizenInputToValidate->name;

                Yii::$app->session->open();
                Yii::$app->session->set("email", $email);

                $userid = UserDB::find()
                    ->where(['email' => $newCitizenEmail->id])
                    ->all()[0]['id'];

                Yii::$app->session->set("id", $userid);
                Yii::$app->session->set("type", "1");

                $resolveToUser['newUrl'] = "/index.php?r=profile%2Fprofile-citizen";

                $json = json_encode($resolveToUser);

                return $json;
            }

            // если уже зарегистрирован человек
            $resolveToUser['errors']['isRegistered'] = true;

            $json = json_encode($resolveToUser);
            
            return $json;
        }
        // модель не валидна
        else
        {
           
            /**
             * Типы ошибок в последовательности
             *
             * Заполните все поля
             * Возникает когда хоть в одном есть слово blank
             * email password password_repeat name
             * isEmpty = true
             *
             * Email не корректный
             * Свойство email это "Email is not a valid email address."
             * isEmailCorrected = true
             *
             * Пароль не корректный
             * Свойство password это "Password should contain at least 6 characters."
             * isPassCorrected = true
             *
             * Пароли не совпадают
             * Свойство password это "Password must be equal to \"Password Repeat\"."
             * isPassEquals = true
             */

            // заполните все поля 

            $errors = $citizenInputToValidate->errors;

            $file =  fopen("../web/logs/errors_post.txt","a");

            $text = json_encode($errors)."\n\n";//serialize($errors)."\n"; // (($isValidate) ? "yes" : 'no')."\n";////$errors["INN"][0]."\n";

            fwrite($file, $text);
            fclose($file);     

            $f = false;
            foreach ($errors as $value){
                if (strripos($value[0], 'blank') !== false)
                    $f = true;
            }

            if (!$f){
                if (!(array_key_exists('email', $errors))){
                    if ($errors['password'][0] !== "Password should contain at least 8 characters." and $errors['password'][0] !== "Password should contain at most 32 characters."){
                        
                        $resolveToUser['errors']['isPassEqual'] = true;
                    }
                    else {
                        $resolveToUser['errors']['isPassCorrected'] = true;
                    }
                }
                else {
                    $resolveToUser['errors']['isEmailCorrected'] = true;
                }
            }
            else {
                $resolveToUser['errors']['isEmpty'] = true;
            }


            $json = json_encode($resolveToUser);

            return $json;
        }


    }

}
