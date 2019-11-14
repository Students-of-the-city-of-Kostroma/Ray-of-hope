<?php 
//require_once "../functions/functions.php";
require_once $_SERVER['DOCUMENT_ROOT']."/functions/functions.php";
//require_once "../functions/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT']."/functions/classes/Database.php";
if (isset($_SESSION['logged_org']) && isset($_GET['id_view_org'])) : ?>
<?php 
$id_view_org=$_GET['id_view_org'];  
$db=new Database();
$orgInfo=$db->orgInfo($id_view_org);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../assets/css/normalize.css" rel="stylesheet">
    <link href="../assets/css/styles2_copy4.css" rel="stylesheet">
    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="../assets/js/nav-mark.js"></script>
    <script src="../assets/js/jquery.maskedinput2.min.js"></script>
    <title><?php echo $orgInfo['name']; ?></title>
</head>
<body>
    <?php include 'header2.php'; ?>
    <?php include '../dialog-wrapper.php'; ?>
    <?php include 'newpost.php'; ?>
    <div class="container">
        <div class="frame profileInfo">
            <div class="info">
                <div class="avatar-name-activity-city">
                    <div class="avatar-wrapper">
                        <div class="avatar-doublewrapper">
                            <img src="<?php echo $orgInfo['avatar']; ?>" alt="avatar" class="avatar">
                        </div>
                    </div>  
                    <div class="name-activity-city">
                        <div class="name wrapper"><?php echo $orgInfo['name']; ?></div>
                        <?php 
                        if (isset($orgInfo['type_of_activity'])){
                            echo "<div class=\"activity-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico activity\" src=\"../assets/img/ico_activity.png\"></div><span>".$orgInfo['type_of_activity_name']."</span></div>";
                        }   
                        if (isset($orgInfo['city_name']))
                        {
                            echo "<div class=\"city-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico city\" src=\"../assets/img/ico_city.png\"></div><span>".$orgInfo['city_name']."</span></div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="description-contacts-buttons">
                    <?php 
                    if (isset($orgInfo['description']) && $orgInfo['description']!=""){
                        echo "<div class=\"description-wrapper\"><span class=\"title\">Описание:</span><div class=\"description-wrapper2\"><span data-min=\"".$orgInfo['description']."\" data-full=\"".$orgInfo['description']."\" class=\"text\">".$orgInfo['description']."</span><span class=\"moreTextBtn noclick\">Больше</span></div></div>";
                    }
                    ?> 
                    <div class="contacts-wrapper">
                        <?php
                        if (isset($orgInfo['address']) || isset($orgInfo['number_phone'])){
                            echo "<span class=\"title\">Контакты:</span>";
                            if (isset($orgInfo['address'])){
                            echo "<div class=\"home-city-wrapper\">
                            <img class=\"ico\" src=\"../assets/img/home_city_icon.png\">
                            <span class=\"home-city\">".$orgInfo['address']."</span>
                            </div>";
                            }
                            if (isset($orgInfo['number_phone'])){
                            echo "<div class=\"phone-wrapper\">
                            <img class=\"ico\" src=\"../assets/img/phone_icon.png\">
                            <span class=\"phone-number\">".$orgInfo['number_phone']."</span>
                            </div>";
                            }
                        }
                        ?>
                    </div>
                    
                    <div class="buttons-wrapper">
                        <?php 
                        if ($_GET['id_view_org']==$_SESSION['logged_org']){
                            echo "<a href=\"/edit\" class=\"edit-profile-link\"><img class=\"edit-icon\" src=\"../assets/img/edit_profile_icon.png\"><span>Редактировать профиль</span></a>";
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
                <div class="frame post occurrence">
                    <div class="avatar_name_date_delete">
                        <a href="" class="avatar_name">
                            <img href="" src="<?php echo $orgInfo['avatar']; ?>" class="post_avatar">
                            <span class="post_name"><?php echo $orgInfo['name']; ?></span>
                        </a>
                        <div class="date_delete">
                            <span class="post_date">1 июля в 22:33</span>
                            <button class="post_delete">
                                <img src="/assets/img/delete_post_icon.png">
                            </button>
                        </div>
                    </div>
                    <span class="post_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia </span>
                    <div class="post_img_list">
                        <img src="../user_data/docs/2/doc_5d62586c21b5b.jpg" class="post_img">
                    </div>
                    <div class="post_comments_bookmarks">
                        <a href="" class="post_comments">
                            <img src="/assets/img/comments_icon.png" class="post_comments_icon">
                            <span class="post_comments_count">27</span>
                        </a>
                        <button class="post_bookmarks">
                            <img src="/assets/img/bookmarks_icon.png">
                        </button>
                    </div>
                </div>
                <div class="frame post event">
                    <div class="avatar_name_date_delete">
                        <a href="" class="avatar_name">
                            <img href="" src="<?php echo $orgInfo['avatar']; ?>" class="post_avatar">
                            <span class="post_name"><?php echo $orgInfo['name']; ?></span>
                        </a>
                        <div class="date_delete">
                            <span class="post_date">1 июля в 22:33</span>
                            <button class="post_delete">
                                <img src="/assets/img/delete_post_icon.png">
                            </button>
                        </div>
                    </div>
                    <span class="post_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia </span>
                    <div class="post_img_list">
                        <img src="/user_data/docs/2/doc_5d62586c21e28.jpg" class="post_img">
                    </div>
                    <div class="location_date">
                        <img src="/assets/img/ico_city.png">
                        <div class="location_date_wrapper">
                            <span class="date">27 июля в 13:00</span>
                            <span class="location">Совесткая улица, 13</span>
                        </div>
                    </div>
                    <div class="post_comments_bookmarks">
                        <a href="" class="post_comments">
                            <img src="/assets/img/comments_icon.png" class="post_comments_icon">
                            <span class="post_comments_count">27</span>
                        </a>
                        <button class="post_bookmarks">
                            <img src="/assets/img/bookmarks_icon.png">
                        </button>
                    </div>
                </div>
                <div class="frame post need">
                    <div class="avatar_name_date_delete">
                        <a href="" class="avatar_name">
                            <img href="" src="<?php echo $orgInfo['avatar']; ?>" class="post_avatar">
                            <span class="post_name"><?php echo $orgInfo['name']; ?></span>
                        </a>
                        <div class="date_delete">
                            <span class="post_date">1 июля в 22:33</span>
                            <button class="post_delete">
                                <img src="/assets/img/delete_post_icon.png">
                            </button>
                        </div>
                    </div>
                    <span class="post_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia </span>
                    <div class="post_img_list">
                        <img src="/user_data/docs/2/doc_5d62586c21e28.jpg" class="post_img">
                    </div>
                    <div class="progress">
                        <div class="count">
                            <span class="collected_count">27943</span>
                            <span class="need_count">100000</span>
                        </div>
                        <div class="bar">
                            <div class="line_full">
                                <div class="line_collected">
                                    <!--
                                    <button class="marker">
                                        <div class="marker_hint"></div>
                                    </button>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post_comments_bookmarks">
                        <a href="" class="post_comments">
                            <img src="/assets/img/comments_icon.png" class="post_comments_icon">
                            <span class="post_comments_count">27</span>
                        </a>
                        <button class="post_bookmarks">
                            <img src="/assets/img/bookmarks_icon.png">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/newpost26.js"></script>
    <script src="../assets/js/profile_org.js"></script>
</body>
</html>
<?php else : ?>
<?php header("Location: /login/org"); ?>
<?php endif; ?>