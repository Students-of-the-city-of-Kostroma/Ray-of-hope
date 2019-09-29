<?php

//начало сессии, в сессии хранится инфа о конкретном пользователе, сама сессия хранится на сервере (вроде несколько часов)

session_start();

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

//перевод русских букв в латиницу, будет нужно для имен файлов
function cyrillic_translit( $title ){
    $iso9_table = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
        'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
        'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
        'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
        'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
        'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
        'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
        'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
        'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
        'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
        'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
    );

    $name = strtr( $title, $iso9_table );
    $name = preg_replace('~[^A-Za-z0-9\'_\-\.]~', '-', $name );
    $name = preg_replace('~\-+~', '-', $name ); // --- на -
    $name = preg_replace('~^-+|-+$~', '', $name ); // кил - на концах

    return $name;
}

function getOrgInfo($id){
    $errors=array();
    $mysqli=connectBD();
    $result = ($mysqli->query("SELECT * FROM `accounts_organization2` WHERE id='$id'"));
    $count = mysqli_num_rows($result);
    if ($count>0){
    $orgInfo=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `id`, `name`, `avatar`, `city`, `description`, `contacts`, `type_of_activity` FROM `accounts_organization2` WHERE `id` = '$id'"));
    $org_info=array();
    
   
    $org_info['org_avatar'] = is_null($orgInfo['avatar']) ?  "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/noavatar.jpg" : "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/".$orgInfo['avatar'].".jpg"; 
    $org_info['org_name'] = $orgInfo['name'];
    $org_info['org_city'] = $orgInfo['city'];
    
    $city_id=$org_info['org_city'];
    $org_info['org_city_name'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))['name'] : null;
    
    $org_info['org_docs'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE `id` = '$id'"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE `id` = '$id'"))['docs'] : null;
    $docs_links=array();
    $docs_preview=array();
    if (isset($org_info['org_docs'])){
           
        $dir  = '../user_data/docs/'.$org_info['org_docs'];
        $catalog=opendir($dir);
        $list=array();
        while($file=readdir($catalog)){
            if ($file != '.' && $file!='..' && $file[strlen($file)-1]!='~'){
                $ctime=filectime("$dir/$file").','.$file;
                $list[$ctime]=$file;
            }
        }
        closedir($catalog);
        ksort($list); //сортированный по дате массив файлов
        
        for ($i=0;$i<count($list);$i++){
            if (!is_dir("../user_data/docs/".$id."/".array_values($list)[$i])){
                $path_parts = pathinfo("../user_data/docs/".$id."/".array_values($list)[$i]);  
                if ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx"){
                    $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                    $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/preview/".$path_parts['filename'].".png";
                    continue;
                }
                if ($path_parts['extension']=="jpg"){
                    $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                    $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                    continue;
                }
            }
        }
    }
    $org_info['docs_links']=$docs_links;
    $org_info['docs_preview']=$docs_preview;
    
    
    $org_info['org_activity'] = $orgInfo['type_of_activity'];
    $org_info['org_description'] = $orgInfo['description'];
    $org_info['org_contacts'] = $orgInfo['contacts'];
    
    closeBD($mysqli);
    return $org_info;
    }
    else{
        array_push($errors, 'not_found_org');
        return $errors;
    }
}

function loginOrg($email_or_inn, $password){
    $errors = array();
    if (!empty($email_or_inn) && !empty($password)) {
        $result = login_org_check($email_or_inn, $password);
        if ($result!=false){
            $mysqli=connectBD();
            $_SESSION['logged_org']=$result['id'];
            $_SESSION['org_avatar'] = $result['avatar']; 
            $_SESSION['org_name'] = $result['name'];
            $_SESSION['org_city'] = $result['city'];
            $city_id=$_SESSION['org_city'];
            $_SESSION['org_city_name'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))['name'] : null;
            $_SESSION['org_docs'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE (`email`='$email_or_inn' OR `inn`='$email_or_inn')"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE (`email`='$email_or_inn' OR `inn`='$email_or_inn')"))['docs'] : null;
            $_SESSION['org_activity'] = $result['type_of_activity'];
            $_SESSION['org_description'] = $result['description'];
            $_SESSION['org_contacts'] = $result['contacts'];
            
            $org_id=$_SESSION['logged_org'];
            $docs_links=array();
            $docs_preview=array();
            if (isset($_SESSION['org_docs'])){
                $dir  = '../user_data/docs/'.$_SESSION['org_docs'];
                $catalog=opendir($dir);
                $list=array();
                while($file=readdir($catalog)){
                    if ($file != '.' && $file!='..' && $file[strlen($file)-1]!='~'){
                        $ctime=filectime("$dir/$file").','.$file;
                        $list[$ctime]=$file;
                    }
                }
                closedir($catalog);
                ksort($list); //сортированный по дате массив файлов
                
                for ($i=0;$i<count($list);$i++){
                    if (!is_dir("../user_data/docs/".$org_id."/".array_values($list)[$i])){
                        $path_parts = pathinfo("../user_data/docs/".$org_id."/".array_values($list)[$i]);  
                        if ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx"){
                            $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$org_id."/".array_values($list)[$i];
                            $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$org_id."/preview/".$path_parts['filename'].".png";
                            continue;
                        }
                        if ($path_parts['extension']=="jpg"){
                            $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$org_id."/".array_values($list)[$i];
                            $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$org_id."/".array_values($list)[$i];
                            continue;
                        }
                    }
                }
            }
            $result['docs_links']=$docs_links;
            $result['docs_preview']=$docs_preview;
            
            closeBD($mysqli);
            unset($result['hash']);
            $result['avatar'] = is_null($result['avatar']) ?  "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/noavatar.jpg" : "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/".$result['avatar'].".jpg"; 
            unset($result['docs']);
            $result['successful_authorization']=1;
            return $result;
        }
        else{
            array_push($errors, 'not_found_org');
        }
    }
    else {
        array_push($errors, 'empty');
    }
	return $errors;
}

if (isset($_POST['profile_org_info']) && isset($_POST['org_id'])){
    echo json_encode(getOrgInfo($_POST['org_id']));
}


//обработка пост запроса редактиррвания профиля организации
if (isset($_POST['edit_profile_org'])){
    $errors=array();
    $mysqli=connectBD();
    
    $id_org=$_SESSION['logged_org'];
    $name=$_POST['name'];
    $city=$_POST['city'];
    
    $_SESSION['org_city_name']=$_POST['city_name'];
    
    
    $activity=$_POST['activity'];
    $description=$_POST['description'];
    $contacts=$_POST['contacts'];
    
    //если изменялся аватар (в массиве есть ключ-аватар) - проверяем тип файла и загружаем на хостинг
    if (isset($_FILES['avatar'])){
        $allowed =  array('jpg');
        $filename = $_FILES['document']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) || mime_content_type($_FILES['avatar']['tmp_name'])!="image/jpeg") {
            die(header("HTTP/1.0 666 error_file_type"));
        }
	    $uploaddir_avatar = '../user_data/avatar'; //  - папка с аватарами пользователей
	    // cоздадим папку если её нет
	    if( ! is_dir( $uploaddir_avatar ) ) mkdir( $uploaddir_avatar, 0777 );
		if( move_uploaded_file( $_FILES['avatar']['tmp_name'], "$uploaddir_avatar/$id_org".".jpg") ){
			mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `avatar`=$id_org WHERE `id`=$id_org");
			$_SESSION['org_avatar']=$id_org;
		}
		else{
		    array_push($errors, 'avatar');	
		}
    }
    
    
    //если добавлялись документы - проверяем каждый файл и сохраняем на хостинг
    if (isset($_FILES['docs'])){
        
        $allowed =  array('jpg', 'docx', 'pdf');
        $allowedContentType =  array('image/jpeg', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf');
        $uploaddir = '../user_data/docs/'.$id_org; //  - папка с документами пользователей
    	// cоздадим папку если её нет
    	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
    	$docError=false;
    for($i=0; $i<count($_FILES['docs']['name']); $i++){
        $filename = $_FILES['docs']['name'][$i];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) || !in_array(mime_content_type($_FILES['docs']['tmp_name'][$i]),$allowedContentType)){
            die(header("HTTP/1.0 666 error_file_type"));
        }
        $uniqFileID=uniqid('doc_');
        $filename = $uniqFileID.'.'.pathinfo($_FILES['docs']['name'][$i], PATHINFO_EXTENSION); //имя файла с префиксом "doc_" в папке на хостинге
        if(move_uploaded_file($_FILES['docs']['tmp_name'][$i],"$uploaddir/$filename")){
            if ($_FILES['docs']['type'][$i]==="application/pdf" || $_FILES['docs']['type'][$i]==="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
                if (isset($_FILES['preview'])){
                    $previewDir = $uploaddir.'/preview';
                    if ( ! is_dir( $previewDir ) ) mkdir( $previewDir, 0777 );
                    for($j=0; $j<count($_FILES['preview']['name']); $j++){
                        if ($_FILES['preview']['name'][$j]==$_FILES['docs']['name'][$i]){
                            $data = file_get_contents($_FILES['preview']['tmp_name'][$j]);
                            list($type, $data) = explode(';', $data);
                            list(, $data)      = explode(',', $data);
                            $data = base64_decode($data);
                            file_put_contents($_FILES['preview']['tmp_name'][$j], $data);
                            move_uploaded_file($_FILES['preview']['tmp_name'][$j],$previewDir.'/'.$uniqFileID.'.png');
                        }
                    }
                }
            }
            
			mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `docs`=$id_org WHERE `id`=$id_org");
			$_SESSION['org_docs']=$id_org;
		}
    }
    if ($docError){array_push($errors, 'doc');}
    }
	
	//если изменялось имя - записываем в бд
	if (isset($_POST['name'])){
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `name`='$name' WHERE `id`='$id_org'"))
	    {
	        array_push($errors, 'name');
	    }
	    else{$_SESSION['org_name']=$name;}
	}
	
	//если есть ключ для города - записываем в бд (проверка не через isset, т.к. в городе может быть null)
	if (array_key_exists('city',$_POST)){
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `city`=$city WHERE `id`='$id_org'"))
	    {
	        array_push($errors,'city');
	    }
	    else{$_SESSION['org_city']=$city;}
	}
	
	//то же самое, что с городом
	if (array_key_exists('activity',$_POST)){
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `type_of_activity`='$activity' WHERE `id`='$id_org'"))
	    {
	        array_push($errors, 'activity');
	    } 
	    else{$_SESSION['org_activity']=$activity;}
	}
	
	//если изменялось имя - пишем в бд
	if (isset($_POST['description'])){
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `description`='$description' WHERE `id`='$id_org'"))
	    {
	        array_push($errors, 'description');
	    }
	    else{$_SESSION['org_description']=$description;}
	}
	
	//если изменялись контакты
	if (isset($_POST['contacts'])){
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `contacts`='$contacts' WHERE `id`='$id_org'"))
	    {
	        array_push($errors, 'contacts');
	    }
	    else{$_SESSION['org_contacts']=$contacts;}
	}
	closeBD($mysqli);
	
	//возвращаем json с ошибками (в идеале он пустой)
	echo json_encode($errors);
}

//обработка пост запроса для подсказок города
if (isset($_POST["request"])){
    getCityList($_POST["request"]);
}

//обработка запроса авторизации
/*
if (isset($_POST["login_org"]) && isset($_POST["email_or_inn"]) && isset($_POST["password"])){
	echo json_encode(loginOrg($_POST["email_or_inn"], $_POST["password"]));
}
*/
if (isset($_POST["login_org"]) && isset($_POST["email_or_inn"]) && isset($_POST["password"])){
    
    include 'classes/Database.php';
    $db = new Database();
    
    $id=$db->email2id($_POST["email_or_inn"]);
    
    $info=$db->orgInfo($id);
    if (!isset($info['not_found_org'])){
        $_SESSION['logged_org']=$info['id'];
        $_SESSION['org_avatar'] = $info['avatar']; 
        $_SESSION['org_name'] = $info['name'];
        $_SESSION['org_city'] = $info['city_name'];
        $_SESSION['org_docs'] = $info['docs'];;
        $_SESSION['org_activity'] = $info['type_of_activity'];
        $_SESSION['org_description'] = $info['description'];
        $_SESSION['number_phone'] = $info['number_phone'];
        $info['successful_authorization']=1;
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
    $errors = array();
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["INN"]) && !empty($_POST["password"])) {
        
		$password = $_POST['password'];
        $email = $_POST['email'];        
        $name = $_POST['name'];
        $INN = $_POST['INN'];
        $password = clean($password);
        $email = clean($email);
        $INN = clean($INN);
        $name = clean($name);
        if (!validate_name($name)) {
            array_push($errors, 'name');
        }
        if (!validate_email($email)) {
            array_push($errors, 'email');
        }
        if (!validate_inn($INN)) {
            array_push($errors, 'INN');
        }
        if (!emailIsFree($email)) {
            array_push($errors, 'emailNotFree');
        }
		else{
			if (!audit_check($INN)) {
				array_push($errors, 'audit');
			}
		}
        if (!validate_password($password)) {
            array_push($errors, 'password');
        }
        if (empty($errors)) {
            reg_org($INN, $password, $email, $name);
        }
    } else {
        array_push($errors, 'empty');
    }
    echo json_encode($errors);
}

//проверка что почта не занята в бд
function emailIsFree($email){
    $mysqli = connectBD();
    $result = mysqli_num_rows($mysqli->query("SELECT * FROM `accounts_organization2` WHERE `email` = '$email'"));
    closeBD($mysqli);
    return ($result==0);
}
function closeBD($mysqli){
    $mysqli->close();
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
function connectBD(){
    return new mysqli("localhost", "id10080061_admin", "3RbrLkk2VX9EipG", "id10080061_rayofhope");
}

//активация пользователя (вызывантся после подтверждения почты)
function activateUserOrg($email){
    
    $mysqli = connectBD();
    
    $mysqli->query("UPDATE `accounts_organization2` SET `status`=1 WHERE `email`='$email'");
    
   
    closeBD($mysqli);  
}

//создант хеш-клбч для пользователя по его почте (нужен для подтверждения почты)
function get_hash($email){
    $secret="rayofhope_secret";
    $hash=md5($email.$secret);
    return $hash;
}

//сравнивает хеш пользователя с его хешем в бд
function checkHash($email,$hash){
    $real_hash=get_real_hash($email);
    return $real_hash === $hash;
}

//получает хеш из бд по почте пользователя
function get_real_hash($email){
    $mysqli = connectBD();

    $result=$mysqli->query("SELECT `hash` FROM `accounts_organization2` WHERE `email`='$email'");
    $row = $result->fetch_assoc();
    $result->close();    
    closeBD($mysqli);
    return $row['hash'];
}

//регистрация организации, добавляет в бд новую запись, отправляет письмо на почту для подтверждения
function reg_org($inn, $password, $email, $name){
    $hash=get_hash($email);
    $mysqli=connectBD();    
    $mysqli->query("INSERT INTO `accounts_organization2` (`name`, `email`, `inn`, `password`, `hash`) VALUES ('$name', '$email', '$inn', '$password', '$hash')");
   
    $headers = "Content-type: text/html; charset=utf-8\r\n";
   
    $text = "<html>
    <head>
    <title>Подтверждение регистрации</title>
    </head>
    <body>
    <table>
    <tr>
    <th>Здравствуйте, $name</th>
    </tr>
    <tr>Для завершения регистрации перейдите по ссылке: https://rayofhope-opensource.000webhostapp.com/confirm_org.php?email=$email&hash=$hash
    </tr>
    </table>
    </body>
    </html>
    ";

    mail($email, 'Подтверждение регистрации', $text, $headers);
    closeBD($mysqli);
}

//проверка инн по базе фнс через api сервиса dadata
function audit_check($INN){
	$ch = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Token 4a11d013ae5f87468fcc2950cd81ea7cbf6d4300'
    ));
    $str = '{' . '"query" : "' . $INN . '"}'; 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $str);


    $result = curl_exec($ch);	
    curl_close($ch);
	$resultPHP = json_decode($result, true);	
	return (count($resultPHP['suggestions'])>0);
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
//проверка email стандартным фильтром php
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
//проверка нащвания организации через регулярное выражение и длинну строки (до 100 символов, буквы, цифры, щапятая и тире)
function validate_name($name)
{
    return (strlen($name) <= 100 && !preg_match('/[^a-zA-ZА-Яа-я0-9 ,-]/u', $name));
}
//проверка пароля (от 6 символов, английские буквы, цифры, запятая, тире)
function validate_password($password)
{
    return (strlen($password) >= 6 && strlen($password) <= 100 && !preg_match('/[^A-Za-z0-9,\\-]/', $password));
}

//проверка инн по контрольной сумме
function validate_inn($inn)
{
    if (preg_match('/\D/', $inn)) return false;

    $inn = (string) $inn;
    $len = strlen($inn);

    if ($len === 10) {
        return $inn[9] === (string) (((2 * $inn[0] + 4 * $inn[1] + 10 * $inn[2] +
            3 * $inn[3] + 5 * $inn[4] +  9 * $inn[5] +
            4 * $inn[6] + 6 * $inn[7] +  8 * $inn[8]) % 11) % 10);
    } elseif ($len === 12) {
        $num10 = (string) (((7 * $inn[0] + 2 * $inn[1] + 4 * $inn[2] +
            10 * $inn[3] + 3 * $inn[4] + 5 * $inn[5] +
            9 * $inn[6] + 4 * $inn[7] + 6 * $inn[8] +
            8 * $inn[9]) % 11) % 10);

        $num11 = (string) (((3 * $inn[0] +  7 * $inn[1] + 2 * $inn[2] +
            4 * $inn[3] + 10 * $inn[4] + 3 * $inn[5] +
            5 * $inn[6] +  9 * $inn[7] + 4 * $inn[8] +
            6 * $inn[9] +  8 * $inn[10]) % 11) % 10);

        return $inn[11] === $num11 && $inn[10] === $num10;
    }
    return false;
}
?>