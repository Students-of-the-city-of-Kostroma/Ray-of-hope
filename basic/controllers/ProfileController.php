<?php

namespace app\controllers;

use app\models\EmailDB;
use app\models\UserDB;
use app\models\CityDB;
use app\models\OrganisationDB;
use yii\web\Controller;
use app\models\TypeOfActivityDB;
use Yii;


class ProfileController extends Controller
{
    public $layout = 'profile';


    public function actionProfileOrganisation()
    {
        // do some session

        return $this->render('profile-org');

    }


    public function actionProfileCitizen()
    {
        // do some session

        return $this->render('profile-cit');

    }

    public function actionProfileOrganisationEdit()
    {
        // do some session

        return $this->render('profile-org-edit');

    }

    public function actionProfileOrganisationSaveEditAddress()
    {
        $request = Yii::$app->request; 

        $ch = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Token 4a11d013ae5f87468fcc2950cd81ea7cbf6d4300'
        ));
        $str = '{' . '"query" : "' . $request->post('request_city'). '", "count": 10}'; 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
    
    
        $result = curl_exec($ch);	
        curl_close($ch);
        return $result;
    }

    public function actionProfileOrganisationSaveEditCity()
    {
        $request = Yii::$app->request; 
        $partOfSity = $request->post('request');

        $cityOfDB = Yii::$app->db->createCommand("SELECT city.id city_id, city.name city_name, region.name region_name FROM city, region WHERE city.region=region.code AND LOWER(city.name) LIKE CONCAT(LOWER(:param1),'%') ORDER BY city.name")
            ->bindValue(':param1', $partOfSity)
            ->queryAll();        

        $file =  fopen("../web/logs/errors_post.txt","a");
        $text = "\n--------------------------\n".var_export($cityOfDB, true)."\n\n";
        fwrite($file, $text);
        fclose($file);    

        return json_encode($cityOfDB, JSON_UNESCAPED_UNICODE);
    }

    public function actionProfileOrganisationSaveEdit()
    {
        
        $request = Yii::$app->request; 

         // $file =  fopen("../web/logs/errors_post.txt","a");
        // $text = var_export($name, true)."\n\n";
        // fwrite($file, $text);
        // fclose($file);    

        $address = $request->post("address");
        if ($address == 'null' or $address == "")
            $address = NULL;    
        
        $name = $request->post("name");
        if ($name == 'null' or $name == "")
            $name = NULL;    
        
        $cityId = $request->post("city");
        if ($cityId == 'null' or $cityId == "")
            $cityId = NULL;    

        $cityName = $request->post("city_name");
        if ($cityName == 'null' or $cityName == "")
            $cityName = NULL;    

        $activity = $request->post("activity");
        if ($activity == 'null' or $activity == "")
            $activity = NULL; 

        $description = $request->post("description");
        if ($description == 'null' or $description == "")
            $description = NULL; 

        $numberPhone = $request->post("number_phone");
        if ($numberPhone == 'null' or $numberPhone == "")
            $numberPhone = NULL; 
        
        $id = Yii::$app->session->get("id");


        $resolveToUser = [
            'url' => null,
            'errors' => [
                'isAddressCorrected' =>     false,
                'isNameCorrected' =>        false,
                'isDescriptionCorrected' => false,
                'isPhoneCorrected' =>       false,                        
            ],            
        ];


        $file =  fopen("../web/logs/errors_post.txt","a");
        $text = var_export($resolveToUser, true)."\n\n";
        fwrite($file, $text);
        fclose($file);    

        $editOrg = OrganisationDB::find()
                ->where(['user_id' => $id])
                ->one();

        
        $user = UserDB::find()
                ->where(['id' => $id])
                ->one();


        if ($address !== NULL and strlen($address) < 257)
            $editOrg->address = $address;
        else if ($address !== NULL and strlen($address) > 256)
            $resolveToUser['errors']['isAddressCorrected'] = true;
        else 
            $editOrg->address = $address;

            
        if ($name !== NULL and strlen($name) < 257)
            $editOrg->name = $name;
        else 
            $resolveToUser['errors']['isNameCorrected'] = true;
            
        
        $editOrg->city = $cityId;
       
        
        // $file =  fopen("../web/logs/errors_post.txt","a");
        // $text = var_export($activity, true)."\n\n";
        // fwrite($file, $text);
        // fclose($file);    

        $editOrg->type_of_activity = $activity;

        // if ($activity !== NULL){                        
        //     $editOrg->type_of_activity = $activity;
        // }
        // else {
        //     #$resolveToUser['errors']['b'] = 2;
        //     $editOrg->type_of_activity = NULL;
        // }


            
        if ($numberPhone !== NULL and strlen($numberPhone) < 257)
            $editOrg->number_phone = $numberPhone;
        else if ($numberPhone !== NULL and strlen($numberPhone) > 256)
            $resolveToUser['errors']['isPhoneCorrected'] = true;
        else
            $editOrg->number_phone = $numberPhone;

            
        if ($description !== NULL and strlen($description) < 257)
            $user->description = $description;
        else if ($description !== NULL and strlen($description) > 256)
            $resolveToUser['errors']['isDescriptionCorrected'] = true;
        else 
            $user->description = $description;

        if ($resolveToUser['errors']['isAddressCorrected'] == false and 
        $resolveToUser['errors']['isNameCorrected'] == false and
        $resolveToUser['errors']['isDescriptionCorrected'] == false and 
        $resolveToUser['errors']['isPhoneCorrected'] == false){
            $resolveToUser['newUrl'] = "ok";

            $editOrg->update();
            $user->update();
        }
        
        $json = json_encode($resolveToUser);

        return $json;

        

    }

    

}