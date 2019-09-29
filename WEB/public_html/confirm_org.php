<?php
if (isset($_GET['email'])&&isset($_GET['hash'])){
require_once "functions/functions.php";
$email = $_GET['email'];
$hash = $_GET['hash'];
if (checkHash($email,$hash)){
    activateUserOrg($email);
    $mysqli=connectBD();    
    
    $orgInfo=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `id`, `name`, `avatar`, `city`, `description`, `contacts`, `type_of_activity` FROM `accounts_organization2` WHERE `email` = '$email'"));
    
    
    $_SESSION['logged_org'] = $orgInfo['id'];
    $_SESSION['org_avatar'] = $orgInfo['avatar']; 
    $_SESSION['org_name'] = $orgInfo['name'];
    $_SESSION['org_city'] = $orgInfo['city'];
    
    $city_id=$_SESSION['org_city'];
    $_SESSION['org_city_name'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))['name'] : null;
    
    $_SESSION['org_docs'] =(mysqli_num_rows(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE `id` = `email` = '$email'"))>0) ? mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `docs` FROM `accounts_organization2` WHERE `email` = '$email'"))['docs'] : null;
    
    $_SESSION['org_activity'] = $orgInfo['type_of_activity'];
    $_SESSION['org_description'] = $orgInfo['description'];
    $_SESSION['org_contacts'] = $orgInfo['contacts'];
    
    closeBD($mysqli);
    header("Location: edit");
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