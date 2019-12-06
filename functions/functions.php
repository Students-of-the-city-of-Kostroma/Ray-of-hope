<?php
@ini_set ('display_errors', 0);

require_once('classes/Database.php');
require_once('classes/Validator.php');

//начало сессии, в сессии хранится инфа о конкретном пользователе, сама сессия хранится на сервере (вроде несколько часов)

session_start();

function closeBD($mysqli){
    $mysqli->close();
}
function connectBD(){
    return new mysqli("localhost", "u238693555_ahyh", "yhyzaqeTuq", "u238693555_ahyh");
}

function city_hints($request){
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
    $str = '{' . '"query" : "' . $request . '", "count": 10}'; 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $str);


    $result = curl_exec($ch);	
    curl_close($ch);
	return $result;
}


if (isset($_POST['city_hints'])&&isset($_POST['request_city'])){
    echo city_hints($_POST['request_city']);
}


if (isset($_POST['profile_org_info']) && isset($_POST['org_id'])){
    $db=new Database();
    $orgInfo=$db->orgInfo($_POST['org_id']);
    echo json_encode($orgInfo);
}

if (isset($_POST['edit_profile_org'])){
    $db=new Database();
    $result=$db->editOrg();
    echo json_encode($result);
}

//обработка пост запроса для подсказок города
if (isset($_POST["request"])){
    $db=new Database();
    $result=$db->getCityList($_POST["request"]);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

//обработка запроса авторизации
if (isset($_POST["login_org"]) && isset($_POST["email_or_inn"]) && isset($_POST["password"])){
    $db = new Database();
    $info=array();
    if ($db->login_org_check($_POST["email_or_inn"], $_POST["password"])){
        $id=$db->email2id($_POST["email_or_inn"]);
        $info=$db->orgInfo($id);
        if (!isset($info['not_found_org'])){
            $_SESSION['logged_org']=$info['id'];
            $_SESSION['org_avatar'] = $info['avatar']; 
            $_SESSION['type_of_activity'] = $info['type_of_activity']; 
            $_SESSION['type_of_activity_name'] = $info['type_of_activity_name']; 
            $_SESSION['number_phone'] = $info['number_phone']; 
            $_SESSION['org_name'] = $info['name'];
            $_SESSION['org_city'] = $info['city_id'];
            $_SESSION['org_city_name'] = $info['city_name'];
            $_SESSION['org_docs'] = $info['docs'];;
            $_SESSION['org_activity'] = $info['type_of_activity'];
            $_SESSION['org_description'] = $info['description'];
            $_SESSION['number_phone'] = $info['number_phone'];
            $_SESSION['address']=$info['address'];
            $info['successful_authorization']=1;
        }
    }
    else{
        $info['login_or_password_error']=1;
    }
	echo json_encode($info);
}

function login_org_check($email_or_inn, $password){
    $mysqli=connectBD();
    $result = ($mysqli->query("SELECT * FROM `accounts_organization2` WHERE (email='$email_or_inn' OR inn='$email_or_inn')  and password='$password'"));
    closeBD($mysqli);
    $count = mysqli_num_rows($result);
    if ($count>0){
        return mysqli_fetch_assoc($result);
    }
    else{
        return false;
    }
}

//обработка пост запроса регистрации организации
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["INN"]) && isset($_POST["password"])) {
    echo json_encode(reg_org($_POST["INN"], $_POST["password"], $_POST["email"], $_POST["name"]));
}

function reg_org($inn, $password, $email, $name){
    $errors = array();
    if (!empty($inn) && !empty($password) && !empty($email) && !empty($name)) {
        $password = clean($password);
        $email = clean($email);
        $inn = clean($inn);
        $name = clean($name);
        if (!Validator::validate_name($name)) {
            array_push($errors, 'name');
        }
        if (!Validator::validate_email($email)) {
            array_push($errors, 'email');
        }
        $db = new Database();
        if (!Validator::validate_inn($inn)) {
            array_push($errors, 'INN');
        }
        else{
            if (!$db->innIsFree($inn)) {
                array_push($errors, 'innNotFree');
            }
        }
        if (!$db->emailIsFree($email)) {
            array_push($errors, 'emailNotFree');
        }
		else{
			if (!Validator::audit_check($inn)) {
				array_push($errors, 'audit');
			}
		}
        if (!Validator::validate_password($password)) {
            array_push($errors, 'password');
        }
        if (empty($errors)) {
            $db->addOrg($inn, $password, $email, $name);
        }
    } else {
        array_push($errors, 'empty');
    }
    return $errors;
}




//активация пользователя (вызывантся после подтверждения почты)
function activateUserOrg($email){
    
    $mysqli = connectBD();
    
    $mysqli->query("UPDATE `accounts_organization2` SET `status`=1 WHERE `email`='$email'");
    
   
    closeBD($mysqli);  
}







//удаляет лишние html теги из строки, приходящей из формы на сайте
function clean($value = "")
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}
//получить список городов из бд, соответсвующих введенной строке
function getCityList($request){
    $mysqli = connectBD();
    $result = $mysqli->query("SELECT geo_city.id, geo_city.name, geo_regions.region FROM geo_city,geo_regions WHERE geo_city.region_id=geo_regions.id AND geo_city.name LIKE '$request%' ORDER BY geo_city.name");
    
    $json_array = array(); 
    while($row = mysqli_fetch_assoc($result))  
    {
        $json_array[] = $row; 
    }  
    echo json_encode($json_array, JSON_UNESCAPED_UNICODE);
}

?>