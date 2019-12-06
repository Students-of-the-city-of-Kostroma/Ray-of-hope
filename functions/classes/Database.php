<?php
require_once $_SERVER['DOCUMENT_ROOT']."/functions/classes/System.php";
class Database {
    private $host  = 'localhost';
    private $user  = 'u238693555_ahel';
    private $password  = 'eRaQyTuteg';
    private $BD  = 'u238693555_ahel';
    private $mysqli = null;
    
    function login_org_check($email_or_inn, $password){
        $this->connect();
        $resultEmail = ($this->mysqli->query("SELECT * FROM user, email WHERE (email.email='$email_or_inn' and email.id=user.email) and user.password='$password'"));
        $resultInn = ($this->mysqli->query("SELECT * FROM user, organization WHERE (organization.INN='456456546' and organization.user_id=user.id) and user.password='$password'"));
        $this->close();
        $countEmail = mysqli_num_rows($resultEmail);
        $countInn = mysqli_num_rows($resultInn);
        if ($countEmail>0 || $countInn>0){
            if ($countEmail>0){
                return mysqli_fetch_assoc($resultEmail);
            }
            else{
                return mysqli_fetch_assoc($resultInn);
            }
        }
        else{
            return false;
        }
    }
    
    
    
    //получить список городов из бд, соответсвующих введенной строке
    function getCityList($request){
        $this->connect();
        $result = $this->mysqli->query("SELECT city.id AS city_id, city.name AS city_name, region.code AS region_id, region.name AS region_name FROM city, region WHERE city.region=region.code AND city.name LIKE '$request%' ORDER BY city.name");
        $cityList = array(); 
        while($row = mysqli_fetch_assoc($result))  
        {
            $cityList[] = $row; 
        }  
        return $cityList;
    }

    function getActivityList(){
        $this->connect();
        $result = ($this->mysqli->query("SELECT * FROM `type_of_activity`"));
        $activityList=array();
        while ($row=mysqli_fetch_assoc($result)){
            $activityList[]=$row;
        }
        $this->close();
        return $activityList;
    }
    function editOrg(){
        $errors=array();
        $this->connect();
        
        $id_org=$_SESSION['logged_org'];
        $name=$_POST['name'];
        
        
        $activity=$_POST['activity'];
        $description=$_POST['description'];
        
        //если изменялся аватар (в массиве есть ключ-аватар) - проверяем тип файла и загружаем на хостинг
        if (isset($_FILES['avatar'])){
            $allowed =  array('jpg');
            $filename = $_FILES['document']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) || mime_content_type($_FILES['avatar']['tmp_name'])!="image/jpeg") {
                die(header("HTTP/1.0 666 error_file_type"));
            }
            $uploaddir_avatar = '../user_data/avatar'; //  - папка с аватарами пользователя
            // cоздадим папку если её нет
            if (!is_dir($uploaddir_avatar)) mkdir($uploaddir_avatar, 0777);
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], "$uploaddir_avatar/$id_org".".jpg")){
                mysqli_query($ершы->mysqli,"UPDATE `organization` SET `avatar`=$id_org WHERE `user_id`=$id_org");
                $_SESSION['org_avatar']=$_SERVER['HTTP_HOST']."/user_data/avatar/".$id_org.".jpg";
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
            if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);
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
                    mysqli_query($this->mysqli,"UPDATE `organization` SET `docs`=$id_org WHERE `user_id`=$id_org");
                    $_SESSION['org_docs']=$id_org;
                }
            }
            if ($docError){
                array_push($errors, 'doc');
            }
        }
        if (isset($_POST['address'])){
            $address=$_POST['address'];
            if(!mysqli_query($this->mysqli,"UPDATE `organization` SET `address`='$address' WHERE `user_id`='$id_org'"))
            {
                array_push($errors, 'address');
            }
            else{
                $_SESSION['address']=$address;
            }
        }
        //если изменялось имя - записываем в бд
        if (isset($_POST['name'])){
            if(!mysqli_query($this->mysqli,"UPDATE `organization` SET `name`='$name' WHERE `user_id`='$id_org'"))
            {
                array_push($errors, 'name');
            }
            else{
                $_SESSION['org_name']=$name;
            }
        }
        //если есть ключ для города - записываем в бд (проверка не через isset, т.к. в городе может быть null)
        if (array_key_exists('city',$_POST)){
            $_SESSION['org_city_name']=$_POST['city_name'];
            $_SESSION['org_city']=$_POST['city'];
            $city = $_POST['city'];
            $city = $city == "" ? null : $city;
            if(isset($city)&&!mysqli_query($this->mysqli,"UPDATE `organization` SET `city`='$city' WHERE `user_id`='$id_org'") || !isset($city)&&!mysqli_query($this->mysqli,"UPDATE `organization` SET `city`=NULL WHERE `user_id`='$id_org'"))
            {
                array_push($errors,'city');
            }
        }
        
        //то же самое, что с активностью
        if (array_key_exists('activity',$_POST)){
            if(!mysqli_query($this->mysqli,"UPDATE `organization` SET `type_of_activity`='$activity' WHERE `user_id`='$id_org'"))
            {
                array_push($errors, 'activity');
            } 
            else{
                $_SESSION['org_activity']=$activity;
            }
        }
        
        //если изменялось описание - пишем в бд
        if (isset($_POST['description'])){
            if(!mysqli_query($this->mysqli,"UPDATE user SET user.description='$description' WHERE user.id='$id_org'")){
                array_push($errors, 'description');
            }
            else{
                $_SESSION['org_description']=$description;
            }
        }
        
        //если изменялся номер
        if (isset($_POST['number_phone'])){
            $number_phone=$_POST['number_phone'];
            if(!mysqli_query($this->mysqli,"UPDATE `organization` SET `number_phone`='$number_phone' WHERE `user_id`='$id_org'")){
                array_push($errors, 'number_phone');
            }
            else{
                $_SESSION['number_phone']=$number_phone;
            }
        }
        $this->close();
        return $errors;
    }
    
    
    function emailIsFree($email){
        $this->connect();
        $result = mysqli_num_rows($this->mysqli->query("SELECT * FROM email WHERE email.email = '$email'"));
        $this->close();
        return ($result==0);
    }
    function innIsFree($inn){
        $this->connect();
        $result = mysqli_num_rows($this->mysqli->query("SELECT * FROM organization WHERE organization.inn = '$inn'"));
        $this->close();
        return ($result==0);
    }
    
    //регистрация организации
    function addOrg($inn, $password, $email, $name){
        $classname = 'System';
        $hash=$classname::generate_hash($email);
        $this->connect();
        
        $this->mysqli->query("INSERT INTO `email` (`email`, `hash`) VALUES ('$email', '$hash')");
        
        $result_emailid=$this->mysqli->query("SELECT id FROM email WHERE email.email='$email'");
        $row = $result_emailid->fetch_assoc();
        $result_emailid->close();    
        $emailid_from_db= $row['id'];
        
        $this->mysqli->query("INSERT INTO `user` (`type_of_account`, `password`, `email`) VALUES (1, '$password', '$emailid_from_db')");
        
        $result_userid=$this->mysqli->query("SELECT id FROM user WHERE user.email='$emailid_from_db'");
        $row = $result_userid->fetch_assoc();
        $result_userid->close();    
        $userid_from_db= $row['id'];
        $this->mysqli->query("INSERT INTO `organization` (`INN`, `user_id`, `name`) VALUES ('$inn', '$userid_from_db', '$name')");
        $this->close();
    }

    static function checkHash($email,$hash){
        $this->get_real_hash($email);
        return $real_hash === $hash;
    }
    
    function activateUserOrg($email){
        $this->connect();
        $this->mysqli->query("UPDATE email SET `status`=1 WHERE email.email='$email'");
        $this->close();
    }
    
    //получает хеш из бд по почте пользователя
    function get_real_hash($email){
        $this->connect();
        $result=$this->mysqli->query("SELECT hash FROM email WHERE email.email='$email'");
        $row = $result->fetch_assoc();
        $result->close();    
        $this->close();
        return $row['hash'];
    }
    
    private function close(){
        if (isset($this->mysqli)){
            $this->mysqli->close();
        }
    }
    
    private function connect(){
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->BD);
    }
    
    public function email2id($email_or_inn){
        $this->connect();
        $result = ($this->mysqli->query("SELECT user.id FROM user JOIN email ON user.email=email.id JOIN organization ON user.id=organization.user_id WHERE email.email='$email_or_inn' OR organization.INN='$email_or_inn'"));
        $id=mysqli_fetch_assoc($result)['id'];
        $this->close();
        return $id;
    }
    
    public function orgInfo($id){
        $this->connect();
        $errors=array();
        $result = ($this->mysqli->query("SELECT user.id, user.avatar, organization.city AS city_id, (SELECT city.region FROM city WHERE city.id=organization.city) AS region_id, user.description, organization.type_of_activity AS type_of_activity, organization.docs AS docs, organization.name , organization.number_phone AS number_phone, (SELECT type_of_activity.name FROM type_of_activity WHERE type_of_activity.id=organization.type_of_activity) AS type_of_activity_name, (SELECT city.name FROM city WHERE city.id=organization.city) AS city_name, (SELECT region.name  FROM region, city WHERE city.id=organization.city AND region.code=city.region) AS region_name, (SELECT organization.address FROM organization WHERE organization.user_id=user.id) AS address FROM user INNER JOIN organization ON user.id = organization.user_id WHERE user.id='$id'"));
        
        
        if ($result!=false && mysqli_num_rows($result)>0){
            $orgInfo=mysqli_fetch_assoc($result);
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
            $orgInfo['avatar'] = is_null($orgInfo['avatar']) ?  $protocol.$_SERVER['HTTP_HOST']."/user_data/avatar/noavatar.jpg" : $protocol.$_SERVER['HTTP_HOST']."/user_data/avatar/".$orgInfo['avatar'].".jpg"; 
            
            $city_id=$orgInfo['city_name'];
            $docs_links=array();
            $docs_preview=array();
            if (isset($orgInfo['docs'])){
                $dir  = '../user_data/docs/'.$orgInfo['docs'];
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
                        if (isset($path_parts['extension']) && ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx")){
                            $docs_links[$i]=$_SERVER['HTTP_HOST']."/user_data/docs/".$id."/".array_values($list)[$i];
                            $docs_preview[$i]=$_SERVER['HTTP_HOST']."/user_data/docs/".$id."/preview/".$path_parts['filename'].".png";
                            continue;
                        }
                        if (isset($path_parts['extension']) &&  $path_parts['extension']=="jpg"){
                            $docs_links[$i]=$_SERVER['HTTP_HOST']."/user_data/docs/".$id."/".array_values($list)[$i];
                            $docs_preview[$i]=$_SERVER['HTTP_HOST']."/user_data/docs/".$id."/".array_values($list)[$i];
                            continue;
                        }
                    }
                }
            }
            $orgInfo['docs_links']=$docs_links;
            $orgInfo['docs_preview']=$docs_preview;
            $this->close($this->mysqli);
            return $orgInfo;
        }
        else{
            $errors['not_found_org']=1;
            $this->close($this->mysqli);
            return $errors;
        }
    }
    
}
?>