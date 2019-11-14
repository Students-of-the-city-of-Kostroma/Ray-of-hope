<?php
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

if (isset($_POST['profile_org_info']) && isset($_POST['org_id'])){
    $db=new Database();
    $orgInfo=$db->orgInfo($_POST['org_id']);
    echo json_encode($orgInfo);
}


/*обработка пост запроса редактиррвания профиля организации
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
    
	if (isset($_POST['address'])){
	    $address=$_POST['address'];
	    if(!mysqli_query($mysqli,"UPDATE `accounts_organization2` SET `address`='$address' WHERE `id`='$id_org'"))
	    {
	        array_push($errors, 'address');
	    }
	    else{$_SESSION['address']=$address;}
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
*/

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