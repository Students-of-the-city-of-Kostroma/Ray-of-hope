<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/functions/classes/Database.php";
if (isset($_SESSION['logged_org']) && isset($_GET['id_view_org'])) : ?>
    <?php
        $id_view_org = $_GET['id_view_org'];
        $db = new Database();
        $orgInfo = $db->orgInfo($id_view_org);
        ?>
    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="/assets/css/normalize.css" rel="stylesheet">
        <link href="/assets/css/styles2_copy4.css" rel="stylesheet">
        <title><?php echo $orgInfo['name']; ?></title>
    </head>

    <body>
        <?php include 'header2.php'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/dialog-wrapper.php'; ?>
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
                                if (isset($orgInfo['type_of_activity'])) {
                                    echo "<div class=\"activity-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico activity\" src=\"/assets/img/ico_activity.png\"></div><span>" . $orgInfo['type_of_activity_name'] . "</span></div>";
                                }
                                if (isset($orgInfo['city_name'])) {
                                    echo "<div class=\"city-wrapper\"><div class=\"ico-wrapper\"><img class=\"ico city\" src=\"/assets/img/ico_city.png\"></div><span>" . $orgInfo['city_name'] . "</span></div>";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="description-contacts-buttons">
                        <?php
                            if (isset($orgInfo['description']) && $orgInfo['description'] != "") {
                                echo "<div class=\"description-wrapper\"><span class=\"title\">Описание:</span><div class=\"description-wrapper2\"><span data-min=\"" . $orgInfo['description'] . "\" data-full=\"" . $orgInfo['description'] . "\" class=\"text\">" . $orgInfo['description'] . "</span><span class=\"moreTextBtn noclick\">Больше</span></div></div>";
                            }
                            ?>
                        <div class="contacts-wrapper">
                            <?php
                                if (isset($orgInfo['address']) || isset($orgInfo['number_phone'])) {
                                    echo "<span class=\"title\">Контакты:</span>";
                                    if (isset($orgInfo['address'])) {
                                        echo "<div class=\"home-city-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/home_city_icon.png\">
                            <span class=\"home-city\">" . $orgInfo['address'] . "</span>
                            </div>";
                                    }
                                    if (isset($orgInfo['number_phone'])) {
                                        echo "<div class=\"phone-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/phone_icon.png\">
                            <span class=\"phone-number\">" . $orgInfo['number_phone'] . "</span>
                            </div>";
                                    }
                                }
                                ?>
                        </div>

                        <div class="buttons-wrapper">
                            <?php
                                if ($_GET['id_view_org'] == $_SESSION['logged_org']) {
                                    echo "<a href=\"/edit\" class=\"edit-profile-link\"><img class=\"edit-icon\" src=\"/assets/img/edit_profile_icon.png\"><span>Редактировать профиль</span></a>";
                                } else {
                                    echo "
                            <button id=\"add-to-favorites\">
                            <img class=\"add-to-favorites-icon\" src=\"/assets/img/plus_new_post_icon.png\">
                            <span>В любимые</span>
                            </button>
                            <button id=\"mess\">
                            <img class=\"mess-icon\" src=\"/assets/img/mess_icon.png\">
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
                        if (isset($orgInfo['docs'])) {
                            echo "<div class=\"list-doc\">";
                            $dir  = $_SERVER['DOCUMENT_ROOT'] . '/user_data/docs/' . $id_view_org;
                            $catalog = opendir($dir);
                            $list = array();
                            while ($file = readdir($catalog)) {
                                if ($file != '.' && $file != '..' && $file[strlen($file) - 1] != '~') {
                                    $ctime = filectime("$dir/$file") . ',' . $file;
                                    $list[$ctime] = $file;
                                }
                            }
                            closedir($catalog);
                            ksort($list); //сортированный по дате массив файлов
                            for ($i = 0; $i < count($list); $i++) {
                                if (!is_dir("/user_data/docs/" . $id_view_org . "/" . array_values($list)[$i])) {
                                    $path_parts = pathinfo("/user_data/docs/" . $id_view_org . "/" . array_values($list)[$i]);
                                    if ($path_parts['extension'] == "pdf" || $path_parts['extension'] == "docx") {
                                        echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"/user_data/docs/" . $id_view_org . "/" . array_values($list)[$i] . "\"><img src=\"/user_data/docs/" . $id_view_org . "/preview/" . $path_parts['filename'] . ".png\"></a></div>";
                                        continue;
                                    }
                                    if ($path_parts['extension'] == "jpg") {
                                        echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"/user_data/docs/" . $id_view_org . "/" . array_values($list)[$i] . "\"><img src=\"/user_data/docs/" . $id_view_org . "/" . array_values($list)[$i] . "\"></a></div>";
                                        continue;
                                    }
                                }
                            }
                            echo "</div>";
                            if (count($list) - 1 > 6) {
                                $count = count($list) - 1;
                                echo "<div class=\"all-doc\">Все документы (" . $count . ")</div>";
                            }
                        }
                        ?>
                </div>
            </div>
            <div id="typePosts_newPost_posts-wrapper" class="typePosts_newPost_posts-wrapper">
                <div class="typePosts_newPost-wrapper">
                    <div class="frame typePost">
                        <input v-model="type_to_filter" id="all_posts" name="typepost" type="radio" value="all" checked>
                        <label class="label_all_inpt" for="all_posts">Все записи</label>

                        <input v-model="type_to_filter" id="need_posts" name="typepost" type="radio" value="need">
                        <label for="need_posts">Нужда</label>

                        <input v-model="type_to_filter" id="event_posts" name="typepost" type="radio" value="event">
                        <label for="event_posts">Мероприятие</label>

                        <input v-model="type_to_filter" id="occurrence_posts" name="typepost" type="radio" value="occurrence">
                        <label for="occurrence_posts">Событие</label>
                    </div>
                    <?php
                        if ($_GET['id_view_org'] == $_SESSION['logged_org']) {
                            echo "<div class=\"frame newPost\"><button class=\"new_post\"><img src=\"/assets/img/plus_new_post_icon.png\"><span class=\"new_post\">Новый пост</span></button></div>";
                        }
                        ?>
                </div>
                <div class="posts-wrapper">
                    <div v-for="(post, index) in filteredPosts" class="frame post" v-bind:class="post.type">
                        <div class="avatar_name_date_delete">
                            <a href="" class="avatar_name">
                                <img href="" src="<?php echo $orgInfo['avatar']; ?>" class="post_avatar">
                                <span class="post_name"><?php echo $orgInfo['name']; ?></span>
                            </a>
                            <div class="date_delete">
                                <span class="post_date">{{post.date}}</span>
                                <button class="post_delete" v-on:click="posts.splice(index, 1)">
                                    <img src="/assets/img/delete_post_icon.png">
                                </button>
                            </div>
                        </div>
                        <span class="post_text">{{post.text}}</span>
                        <div class="post_img_list">
                            <img v-for="img in post.images" v-bind:src="img" class="post_img">
                        </div>
                        <div v-if="post.type=='event'" class="location_date">
                            <img src="/assets/img/ico_city.png">
                            <div class="location_date_wrapper">
                                <span class="date">{{post.event_date}}</span>
                                <span class="location">{{post.event_address}}</span>
                            </div>
                        </div>
                        <div v-if="post.type=='need'" class="progress">
                            <div class="count">
                                <span class="collected_count">{{post.need_collected_count}}</span>
                                <span class="need_count">{{post.need_count}}</span>
                            </div>
                            <div class="bar">
                                <div class="line_full">
                                    <div class="line_collected" :style="{width: progressWidth(index)}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="post_comments_bookmarks">
                            <a href="" class="post_comments">
                                <img src="/assets/img/comments_icon.png" class="post_comments_icon">
                                <span class="post_comments_count">{{post.comments_count}}</span>
                            </a>
                            <button class="post_bookmarks">
                                <img src="/assets/img/bookmarks_icon.png">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (isset($_SERVER['HTTPS'])) {
                echo "<script type=\"text/javascript\" src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>";
            } else {
                echo "<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-3.4.1.min.js\"></script>";
            }
            ?>
        <script type="text/javascript" src="/assets/js/nav-mark2.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.maskedinput2.min.js"></script>
        <script type="text/javascript" src="/assets/js/newpost26.js"></script>
        <script type="text/javascript" src="/assets/js/profile_org.js"></script>
        <script src="/assets/js/post_list.js"></script>
    </body>

    </html>
<?php else : ?>
    <?php header("Location: /login/org"); ?>
<?php endif; ?>