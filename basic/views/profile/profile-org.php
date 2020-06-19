<?php
use app\models\OrganisationDB;
use app\models\CityDB;
use app\models\CitizenDB;
use app\models\UserDB;
use app\models\TypeOfActivityDB;

if (!isset(Yii::$app->session["id"])) {
    return  Yii::$app->response->redirect("/");
}

else {


$this->title = 'Личный профиль';
$id = Yii::$app->session->get("id");
$email = Yii::$app->session->get("email");
$type = Yii::$app->session->get("type");


$user = UserDB::find()
        ->where(['id' => $id])
        ->all();

if ($user[0]["avatar"] !== NULL) {
    $avatar = "/assets/user_data/avatar/".$avatar[0]["avatar"];
}
else {
    $avatar = "/assets/user_data/avatar/noavatar.jpg";
}

$thisUser = OrganisationDB::find()
            ->where(['user_id' => $id])
            ->all();

?>


<link href="/assets/css/newpost3.css" rel="stylesheet">
<div class="newpost-wrapper">
    <div class="container">
        <div class="newpost-window">
            <div class="titlenewpost-close">
                <span class="titlenewpost">Новая запись</span>
                <button class="closenewpost">
                    <img src="/assets/img/close_newpost.png">
                </button>
            </div>
            <div class="listtypepost-contentnewpost">
                <form id="newpost_form">
                    <div class="listtypepost">
                        <div class="typepost_radio">
                            <input class="input_newpost" id="nuzhd_inpt" name="typepost" type="radio" value="nuzhd" checked>
                            <label for="nuzhd_inpt" class="listtypepost_item">Нужда</label>
                            <input class="input_newpost" id="meropr_inpt" name="typepost" type="radio" value="meropr">
                            <label for="meropr_inpt" class="listtypepost_item">Мероприятие</label>
                            <input class="input_newpost" id="sobit_inpt" name="typepost" type="radio" value="sobit">
                            <label for="sobit_inpt" class="listtypepost_item">Событие</label>
                        </div>
                    </div>
                    <div class="content-inputs">
                        <div class="contentnewpost">
                            <div class="text_newpost" contenteditable="true" placeholder="Введите текст..."></div>
                            <div class="imagelist_newpost">
                                <img src="">
                            </div>
                        </div>
                        <div class="variable_block">
                            <div class="variant nuzhda">
                                <div class="imput-title">Количество</div>
                                <input id="countnuzhd" name="countnuzhd" class="countnuzhd" type="number" placeholder="Введите количество...">
                            </div>
                            <div class="variant meropriyatie" style="display: none;">
                                <div class="address meropr wrapper" id="address_meropr_wrapper">
                                    <div class="dropdown" style="z-index: 1;">
                                        <div class="address-list" style="display: none;">
                                            <div v-for="addr in addresses" class="address-item">
                                                <span class="address-value">{{addr.value}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="imput-title" style="z-index: 3;">Место</div>
                                    <input style="z-index: 2;" disabled id="address" name="address" class="address" type="text" placeholder="Введите место...">
                                </div>
                                <div class="meropr-time">
                                    <div class="start-time">
                                        <div class="date wrapper">
                                            <div class="imput-title">Дата начала</div>
                                            <input disabled class="date" placeholder="дд/мм/гггг" name="date-start" type="text">
                                        </div>
                                        <div class="time wrapper">
                                            <div class="imput-title">Время начала</div>
                                            <input disabled class="time" placeholder="чч/мм" name="time-start" type="text">
                                        </div>
                                    </div>
                                    <div class="end-time">
                                        <div class="date wrapper">
                                            <div class="imput-title">Дата завершения</div>
                                            <input disabled class="date" placeholder="дд/мм/гггг" name="date-end" type="text">
                                        </div>
                                        <div class="time wrapper">
                                            <div class="imput-title">Время завершения</div>
                                            <input disabled class="time" placeholder="чч/мм" name="time-end" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="buttons-newpost">
                            <input multiple name="file" id="file" type="file" class="add-image">
                            <label for="file" class="add_photo_newpost">
                                <img src="/assets/img/load_image_new_post.png">
                            </label>
                            <button class="send-newpost">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="frame profileInfo">
        <div class="info">
            <div class="avatar-name-activity-city">
                <div class="avatar-wrapper">
                    <div class="avatar-doublewrapper">

                        <!---->
                        
                        <img src="<?php echo($avatar)?>" alt="" class="avatar">
                        <!---->

                    </div>
                </div>
                <div class="name-activity-city">
                
                    <!---->              
                    <div class="name wrapper"><?php echo($thisUser[0]["name"]) ?></div>
                    <!---->
                
                    <div class="activity-wrapper">
                        <div class="ico-wrapper">
                            <img class="ico activity" src="/assets/img/ico_activity.png">
                        </div>

                        <!--ЕСЛИ УКАЗАН В ПРОФИЛЕ-->
                        <?php
                        if ($thisUser[0]["type_of_activity"] !== NULL) {

                            $typeofactive = TypeOfActivityDB::find()
                            ->where(['id' => $thisUser[0]["type_of_activity"]])
                            ->all();

                            echo("<span>".$typeofactive[0]['name']."</span>");
                        }           
                        else {
                            echo("<span>Мы заботимся о ...</span>");
                        }             
                        ?>
                    </div>
                    
                    <div class="city-wrapper">
                        <div class="ico-wrapper">
                            <img class="ico city" src="/assets/img/ico_city.png">
                        </div>

                        <!--ЕСЛИ УКАЗАН В ПРОФИЛЕ-->
                        <?php
                        if ($thisUser[0]["city"] !== NULL) {

                            $city = CityDB::find()
                            ->where(['id' => $thisUser[0]["city"]])
                            ->all();

                            echo("<span>".$city[0]['name']."</span>");
                        }           
                        else {
                            echo("<span>Мы расположены в ...</span>");
                        }             
                        ?>                        
                    </div>
                        
                </div>
            </div>
            <div class="description-contacts-buttons">


                <div class="description-wrapper">
                    <span class="title">Описание:</span>
                    <div class="description-wrapper2">

                        <!--ЕСЛИ УКАЗАН В ПРОФИЛЕ-->
                        <?php                        
                        

                        if ($user[0]["description"] !== NULL) {                            

                            echo("<span data-min=\"Укороченное описание из БД\" data-full=\"Описание из БД\" class=\"text\">".$user[0]["description"]."</span>");
                        }           
                        else {
                            echo("<span data-min=\"Укороченное описание из БД\" data-full=\"Описание из БД\" class=\"text\">Описание нашей деятельности ...</span>");
                        }             
                        ?>  
                        
                        <span class="moreTextBtn noclick">Больше</span>
                    </div>
                </div>
                
                <div class="contacts-wrapper">

                    <!--ЕСЛИ УКАЗАН В ПРОФИЛЕ-->
                    "<span class="title">Контакты:</span>"

                    <?php
                        if ($thisUser[0]["address"] !== NULL) {                            

                            echo("
                            <div class=\"home-city-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/home_city_icon.png\">
                            <span class=\"home-city\">".$thisUser[0]["address"]."</span>
                            </div>");
                        }           
                        else {
                            echo("
                            <div class=\"home-city-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/home_city_icon.png\">
                            <span class=\"home-city\">Описание нашей деятельности ...</span>
                            </div>");
                        }    
                        if ($thisUser[0]["number_phone"] !== NULL) {                            

                            echo("
                            <div class=\"phone-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/phone_icon.png\">
                            <span class=\"phone-number\">".$thisUser[0]["number_phone"]."</span>
                            </div>");
                        }           
                        else {
                            echo("
                            <div class=\"phone-wrapper\">
                            <img class=\"ico\" src=\"/assets/img/phone_icon.png\">
                            <span class=\"phone-number\">Наш номер телефона ...</span>
                            </div>");
                        }                  
                        ?>              
                </div>

                <div class="buttons-wrapper">

                    
                    <?php
                    # Если пользователь - организация
                    
                    if ($type === "2") {
                        echo("<a href=\"/index.php?r=profile%2Fprofile-organisation-edit\" class=\"edit-profile-link\">
                        <img class=\"edit-icon\" src=\"/assets/img/edit_profile_icon.png\">
                        <span>Редактировать профиль</span>
                    </a>"); 
                    } 

                    # Если пользователь - гражданин 
                    else {
                        echo("<button id=\"add-to-favorites\">
                        <img class=\"add-to-favorites-icon\" src=\"/assets/img/plus_new_post_icon.png\">
                        <span>В любимые</span>
                        </button>
                        <button id=\"mess\">
                        <img class=\"mess-icon\" src=\"/assets/img/mess_icon.png\">
                        <span>Написать</span>
                        </button>
                        <button id=\"donate\">
                        <span>Пожертовать</span>
                        </button>");
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Документы -->
        <div class="docs">
        
            <!-- Если документы есть -->
            <div class="list-doc">
                <?php
                    if ($thisUser[0]["docs"] !== NULL) {
                        echo "<div class=\"list-doc\">";
                        $dir  = $_SERVER['DOCUMENT_ROOT'] . '/assets/user_data/docs/' . $id;
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
                    else {
                        echo "<div class=\"all-doc\">Наши документы ... </div>";
                    }
                ?>
            </div>                    
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

            <!-- Если пользователь - организация -->
            <?php
            if ($type == "2") 
            echo "<div class=\"frame newPost\">
                <button class=\"new_post\">
                    <img src=\"/assets/img/plus_new_post_icon.png\">
                    <span class=\"new_post\">Новый пост</span>
                </button>
            </div>"
        

            ?>
        </div>
        <div class="posts-wrapper">
            <div v-for="(post, index) in filteredPosts" class="frame post" v-bind:class="post.type">
                <div class="avatar_name_date_delete">
                    <a href="" class="avatar_name">

                        <img href="#" src="<?php echo($avatar); ?>" class="post_avatar">
                        <span class="post_name"><?php echo $thisUser[0]["name"]; ?></span>
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

<?php } ?>