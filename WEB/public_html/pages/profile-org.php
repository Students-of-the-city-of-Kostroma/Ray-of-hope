<?php
require_once "../functions/functions.php";
require_once "../functions/classes/Database.php";
if (isset($_SESSION['logged_org']) && isset($_GET['id_view_org'])) : ?>
<?php 
$id_view_org=$_GET['id_view_org'];
$mysqli=connectBD();   
#$orgInfo=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `name`, `avatar`, `city`, `docs`, `description`, `contacts`, `type_of_activity` FROM `accounts_organization2` WHERE `id` = '$id_view_org'")); 
$db=new Database();#новое
$orgInfo=$db->orgInfo($id_view_org);#новое
#closeBD($mysqli);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../assets/css/normalize.css" rel="stylesheet">
    <link href="../assets/css/styles2.css" rel="stylesheet">
    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/nav-mark.js"></script>
    <script src="../assets/js/profile_org.js"></script>
    <title><?php echo $orgInfo['name']; ?></title>
</head>
<body>
    <?php include 'header2.php'; ?>
    <?php include '../dialog-wrapper.php'; ?>
    <div class="container">
        <div class="frame profileInfo">
            <div class="info">
                <div class="avatar-name-activity-city">
                    <div class="avatar-wrapper">
                        <div class="avatar-doublewrapper">
                            <img src="https://rayofhope-opensource.000webhostapp.com/user_data/avatar/<?php if (is_null($orgInfo['avatar'])){ echo "noavatar"; } else{ echo $orgInfo['id']; } ?>.jpg" alt="avatar" class="avatar">
                        </div>
                    </div>  
                    <div class="name-activity-city">
                        <div class="name wrapper"><?php echo $orgInfo['name']; ?></div>
                        <?php 
                        if (isset($orgInfo['type_of_activity'])){
                            echo "<div class=\"activity-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico activity\" src=\"../assets/img/ico_activity.png\"></div><span>".$orgInfo['type_of_activity']."</span></div>";
                        }   
                        #if (isset($orgInfo['city']))
                        if (isset($orgInfo['city_name']))
                        {
                            #$city_id=$orgInfo['city'];
                            #$mysqli=connectBD();  
                            #$city_name = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT `name` FROM `geo_city` WHERE `id` = '$city_id'"))['name'];
                            #closeBD($mysqli);  
                            #echo "<div class=\"city-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico city\" src=\"../assets/img/ico_city.png\"></div><span>".$city_name."</span></div>";
                            echo "<div class=\"city-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico city\" src=\"../assets/img/ico_city.png\"></div><span>".$orgInfo['city_name']."</span></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="description-contacts-buttons">
                    <?php 
                    if (isset($orgInfo['description']) && $orgInfo['description']!=""){
                        echo "<div class=\"description-wrapper\"><span class=\"title\">Описание:</span><span class=\"text\">".$orgInfo['description']."</span></div>";
                    }
                    ?> 
                    <div class="contacts-wrapper">
                        <span class="title">Контакты:</span>
                        <?php
                        if (isset($orgInfo['number_phone'])){
                            echo "<div class=\"home-city-wrapper\">
                            <img class=\"ico\" src=\"../assets/img/home_city_icon.png\">
                            <span class=\"home-city\">".$orgInfo['city_name']."</span>
                        </div>";
                        }
                        if (isset($orgInfo['number_phone'])){
                            echo "<div class=\"phone-wrapper\">
                            <img class=\"ico\" src=\"../assets/img/phone_icon.png\">
                            <span class=\"phone-number\">".$orgInfo['number_phone']."</span>
                        </div>";
                        }
                        ?>
                    </div>
                    
                    <div class="buttons-wrapper">
                        <?php 
                        if ($_GET['id_view_org']==$_SESSION['logged_org']){
                            echo "<a href=\"https://rayofhope-opensource.000webhostapp.com/edit\" class=\"edit-profile-link\"><img class=\"edit-icon\" src=\"../assets/img/edit_profile_icon.png\"><span>Редактировать профиль</span></a>";
                        }
                        else{
                            echo "
                            <button id=\"add-to-favorites\">
                            <img class=\"add-to-favorites-icon\" src=\"../assets/img/plus_new_post_icon.png\">
                            <span>В любимые</span>
                            </button>
                            <button id=\"mess\">
                            <img class=\"mess-icon\" src=\"../assets/img/mess_icon.png\">
                            <span>Написать</span>
                            </button>
                            <button id=\"donate\">
                            <span>Пожертовать</span>
                            </button>";
                        }
                        ?> 
                    </div>
                </div>
            </div>
            <div class="docs">
                    <?php     
                        if (isset($orgInfo['docs'])){
                            echo "<div class=\"list-doc\">";
                            $dir  = '../user_data/docs/'.$id_view_org;
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
                                if (!is_dir("../user_data/docs/".$id_view_org."/".array_values($list)[$i])){
                                $path_parts = pathinfo("../user_data/docs/".$id_view_org."/".array_values($list)[$i]);
                                if ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"../user_data/docs/".$id_view_org."/".array_values($list)[$i]."\"><img src=\"../user_data/docs/".$id_view_org."/preview/".$path_parts['filename'].".png\"></a></div>";
                                    continue;
                                }
                                if ($path_parts['extension']=="jpg"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"../user_data/docs/".$id_view_org."/".array_values($list)[$i]."\"><img src=\"../user_data/docs/".$id_view_org."/".array_values($list)[$i]."\"></a></div>";
                                    continue;
                                }
                            }
                            }
                            echo "</div>";
                            if (count($list)-1>6){
                                $count=count($list)-1;
                                echo "<div class=\"all-doc\">Все документы (".$count.")</div>";
                            }
                        }
                    ?>
            </div>
        </div>
        <div class="typePosts_newPost_posts-wrapper">
            <div class="typePosts_newPost-wrapper">
                <div class="frame typePost">
                    <button id="all" class="active">Все записи</button>
                    <button id="nuzhd">Нужды</button>
                    <button id="meropr">Мероприятия</button>
                    <button id="sobitie">События</button>
                </div>
                <?php
                if ($_GET['id_view_org']==$_SESSION['logged_org'])
                {
                    echo "<div class=\"frame newPost\"><button class=\"new_post\"><img src=\"../assets/img/plus_new_post_icon.png\"><span class=\"new_post\">Новый пост</span></button></div>";
                }
                ?>
            </div>
            <div class="posts-wrapper">
                <div class="frame post">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php else : ?>
<?php header("Location: https://rayofhope-opensource.000webhostapp.com/login/org"); ?>
<?php endif; ?>