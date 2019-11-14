<?php
require_once $_SERVER['DOCUMENT_ROOT']."/functions/functions.php";
if (isset($_GET['email'])&&isset($_GET['hash'])){
$email = $_GET['email'];
$hash = $_GET['hash'];
$db = new Database();
if ($db->checkHash($email,$hash)){
    $db->activateUserOrg($email); 
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
        $_SESSION['successful_authorization']=1;
        header("Location: edit");
        }
    }
    else{
        $_SESSION['error_authorization']=1;
    }
}
else{
    $_SESSION['error_activate']=1;
    header("Location: pages/registration-organization.php");
}
}
else{
    header("Location: pages/registration-organization.php");
}
?>