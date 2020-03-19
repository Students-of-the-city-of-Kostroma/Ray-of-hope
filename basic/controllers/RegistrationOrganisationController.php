<?php

namespace app\controllers;

use app\models\EmailDB;
use app\models\UserDB;
use app\models\OrganisationDB;
use yii\web\Controller;
use app\models\Organisation;

use Yii;


class RegistrationOrganisationController extends Controller
{

    public $layout = 'outside';


    public function actionProfile()
    {
        // do some session

        return $this->render('succesfuly');

    }

    public function isInnExist()
    {
        // Проверяет наличие ИНН в базе ФНС

        return TRUE;
    }


    public function actionCreate()
    {
        $request = Yii::$app->request;

        $orgInputToValidate =  new Organisation();

        // заполняем модель данными из запроса
        // $orgInputToValidate->attributes = $request->post();

        $orgInputToValidate->name = $request->post('name');
        $orgInputToValidate->email = $request->post('email');
        $orgInputToValidate->INN = $request->post('INN');
        $orgInputToValidate->password = $request->post('password');
        $orgInputToValidate->password_repeat = $request->post('password_2');

        // формируем массив для ответов
        $resolveToUser = [
            'newUrl' => null,
            'errors' => [
                'isEmpty' =>            false,
                'isEmailCorrected' =>   false,
                'isINNCorrected' =>     false,
                'isINNinFNS' =>         false,
                'isINNRegistered'=>          false,
                'isPassCorrected' =>    false,
                'isPassEqual' =>        false,
                'isRegistered' =>       false,
            ],

        ];

        // если модель валидна

        $isValidate = $orgInputToValidate->validate(); 

        if ($isValidate and  $this->IsInnExist($orgInputToValidate->INN)) {                    
            
            // ищем, есть ли нужный нам email
            $emailCheck = EmailDB::find()
                ->where(['email' => $orgInputToValidate->email])
                ->all();


            

            // если email не найден -- можно продолжать регаться
            if (count($emailCheck) === 0) {

                $INNCheck = OrganisationDB::find()
                    ->where(['INN' => $orgInputToValidate->INN])
                    ->all();

                if (count($INNCheck) === 0) {

                    $newOrgEmail = new EmailDB();

                    $newOrgEmail->email = $orgInputToValidate->email;

                    $hashToEmail = md5($orgInputToValidate->email);

                    $newOrgEmail->hash = $hashToEmail;

                    // отправляем письмо с hash для регистрации

                    $newOrgEmail->save();

                    $newOrgAllInfo = new UserDB();

                    $newOrgAllInfo->email = $newOrgEmail->id;
                    $newOrgAllInfo->password = md5($orgInputToValidate->password);
                    $newOrgAllInfo->type_of_account = 2;
                    $newOrgAllInfo->save();

                    $newOrg = new OrganisationDB();
                    $newOrg->user_id = $newOrgAllInfo->id;
                    $newOrg->name = $orgInputToValidate->name;
                    $newOrg->INN = $orgInputToValidate->INN;

                    $newOrg->save();

                    // перенаправляем на нужную страницу
                    $resolveToUser['newUrl'] = "/index.php?r=registration-citizen%2Fprofile";

                    $json = json_encode($resolveToUser);

                    return $json;
                }
                  // если уже зарегистрирован ИНН
                $resolveToUser['errors']['isINNRegistered'] = true;

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

            
            $errors = $orgInputToValidate->errors;

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

                    if (!(array_key_exists('INN', $errors))){                        
                        
                        if (!$isValidate){         

                            if ($errors['password'][0] !== "Password should contain at least 6 characters."){

                                $resolveToUser['errors']['isPassEqual'] = true;
                            }                        
                            else {
                                $resolveToUser['errors']['isPassCorrected'] = true;
                            }
                        }
                        else{
                            $resolveToUser['errors']['isINNinFNS'] = true;
                        }
                    }
                    else {
                        $resolveToUser['errors']['isINNCorrected'] = true;
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
             * INN не корректный
             * Свойство INN это "Inn is invalid."
             * isINNCorrected = true            
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