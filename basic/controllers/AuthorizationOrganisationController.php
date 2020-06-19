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
                'isPassCorrect' => false,
            ],

        ];
        
        $id = 0;
        
        

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
                
                $id = $check[0][$name];

                $passCheck = UserDB::find()
                    ->where(['email' => $check[0][$name]])
                    ->all();

                $passCheckInput = md5($organisationInputToValidate->password);


                if (strval($passCheck[0]["type_of_account"]) !== '2') {
                    $resolveToUser['errors']['isCorrect'] = true;
                }

                else if ($passCheckInput !== $passCheck[0]["password"]) {
                    $resolveToUser['errors']['isPassCorrect'] = true;
                }                
            }
            else {
                $resolveToUser['errors']['isCorrect'] = true;
            }
        }

        // модель не валидна
        else {
                        
            $errors = $organisationInputToValidate->errors;

            $file =  fopen("../web/logs/errors_post.txt","a");

            $text = json_encode($errors)."\n\n";

            fwrite($file, $text);
            fclose($file);     

            $f = false;
                foreach ($errors as $value){
                    if (strripos($value[0], 'blank') !== false)
                        $f = true;
                }    
                
            if ($f){
                $resolveToUser['errors']['isEmpty'] = true;
            }
            else {
                if (!(array_key_exists('password', $errors))){   
                    $resolveToUser['errors']['isCorrect'] = true;
                }
                else {
                    $resolveToUser['errors']['isPassCorrect'] = true;
                }            
            }            
        }
     
        if ($resolveToUser['errors']['isCorrect'] === false and $resolveToUser['errors']['isEmpty'] === false and $resolveToUser['errors']['isPassCorrect'] === false){

            $resolveToUser['newUrl'] = "/index.php?r=profile%2Fprofile-organisation";

            $toEmail = EmailDB::find()
                    ->where(['id' => $id])
                    ->all();

            $email = $toEmail[0]["email"];            

            Yii::$app->session->open();                    
            Yii::$app->session->set("email", $email);


            $userid = UserDB::find()
            ->where(['email' => $id])
            ->all()[0]['id'];

            Yii::$app->session->set("id", $userid);
            Yii::$app->session->set("type", "2");
        }
            

        $json = json_encode($resolveToUser);
        
        return $json;

    }

}
