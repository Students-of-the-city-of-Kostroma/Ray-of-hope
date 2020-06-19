<?php
use app\models\OrganisationDB;
use app\models\CityDB;
use app\models\CitizenDB;
use app\models\UserDB;
use app\models\TypeOfActivityDB;
use yii\helpers\Html;

if (!isset(Yii::$app->session["id"])) {
    return  Yii::$app->response->redirect("/");
}

else {


$this->title = 'Редактирование профиля';
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

$address = $thisUser[0]["address"];
$cityId = $thisUser[0]["city"];

if ($cityId !== NULL){
    $city = CityDB::find()
            ->where(['id' => $cityId])
            ->all();
    $city = $city[0]['name'];
}
else 
    $city = NULL;
            

$name = $thisUser[0]["name"];

$numberPhone = $thisUser[0]["number_phone"];

$typeOfActivityId = $thisUser[0]["type_of_activity"];

if ($typeOfActivityId !== NULL)
    $typeOfActivity = TypeOfActivityDB::find()
                        ->where(['id' => $typeOfActivityId])
                        ->all();

else
    $typeOfActivity = NULL;


$activityList = array(TypeOfActivityDB::find()
                        ->where(['id' => 1])
                        ->all(), 
                    TypeOfActivityDB::find()
                        ->where(['id' => 2])
                        ->all(),
                    TypeOfActivityDB::find()
                        ->where(['id' => 3])
                        ->all());

$description = $user[0]["description"];

$docs = $thisUser[0]["docs"];
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= Html::csrfMetaTags() ?>
    <link href="/assets/css/normalize.css" rel="stylesheet">
    <link href="/assets/css/styles2.css" rel="stylesheet">
    <script src="/assets/js/jquery-3.4.1.min.js"></script>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="/assets/js/nav-mark.js"></script>
    <script src="/assets/js/edit_org.js"></script>
    <title>Редактирование профиля</title>
</head>
<body>
    <div class="container">
        <div class="frame editProfile">
            <div class="info">
                <div class="avatar-name-activity">
                    <div class="avatar-wrapper">
                        <div class="avatar-doublewrapper"><img src="<?php echo $avatar ?>" alt="" class="avatar"></div>
                        <input name="file" id="file" type="file" class="upload_photo">
                        <label for="file" class="upload_photo"></label> 
                    </div>  
                    <div class="name-activity">
                        <div class="name wrapper">
                            <div class="imput-title">Название</div>
                            <input name='name' class='name' type='text' placeholder='Введите название...' value="<?php echo $name ?>">
                        </div>
                        <div class="activity-wrapper">
                            <select required name="activity" class="activity" value="<?php echo $typeOfActivityId ?>">
                                <?php 
                                    if ($typeOfActivityId == NULL){
                                        echo '<option disabled selected value="">Вид деятельности</option>';
                                    }
                                    else{
                                        echo '<option disabled value="">Вид деятельности</option>';
                                    }
                                    foreach ($activityList as $activity){
                                        if ($activity[0]["name"] == $typeOfActivity){
                                            echo '<option selected value="'.$activity[0]['id'].'">'.$activity[0]['name'].'</option>';
                                            continue;
                                        }
                                        echo '<option  value="'.$activity[0]['id'].'">'.$activity[0]['name'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="city wrapper">
                    <div class="dropdown">
                        <div class="city-list"></div>
                    </div>



                    <div class="imput-title" style="z-index: 1;">Город</div>
                    <input value="<?php if ($city !== NULL ) {echo $city;} ?>" id_city="<?php if ($cityId !== NULL ) {echo $cityId;} ?>" id="city" autocomplete="off" name="city" class="city" type="text" placeholder="Введите город...">
                
                
                
                </div>            
                <div class="description wrapper">
                        <div class="imput-title">Описание</div>
                        <textarea name="description" class="description" type="text" placeholder="Введите описание..." ><?php echo $description; ?></textarea>
                </div>                
                <div class="phone wrapper">
                        <div class="imput-title">Телефон</div>
                        <input value="<?php if ($numberPhone !== NULL) echo $numberPhone; ?>" id="phone" name="phone" class="phone" type="number" placeholder="Введите номер телефона...">
                </div>
                <div class="address wrapper">
                    <div class="dropdown">
                        <div class="address-list" style="display: none;"></div>
                    </div>
                    <div class="imput-title" style="z-index: 1;">Адрес</div>
                    <input value="<?php if($address !== NULL) {echo $address;} ?>" id="address" name="address" class="address" type="text" placeholder="Введите адрес...">
                </div>
                <div class="buttons">
                    <button class="payInfoButton">Платёжная информация</button>
                    <button class="saveButton">Сохранить</button>
                </div>
            </div>
            <div class="docs">
                <div class="imput-title-docs">Документы</div>
                <input multiple name="file" id="docUpload" type="file" class="upload_doc">
                <div class="list-doc">
                    <?php     
                        if ($docs != NULL){
                            
                        $dir  = '/assets/user_data/docs/'.$id;
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
                        $org_id=$id;
                        
                        for ($i=0;$i<count($list);$i++){
                            if (!is_dir("/assets/user_data/docs/".$org_id."/".array_values($list)[$i])){
                                
                                $path_parts = pathinfo("/assets/user_data/docs/".$org_id."/".array_values($list)[$i]);
                                if ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"/assets/user_data/docs/".$org_id."/".array_values($list)[$i]."\"><img src=\"/assets/user_data/docs/".$org_id."/preview/".$path_parts['filename'].".png\"></a></div>";
                                    continue;
                                }
                                if ($path_parts['extension']=="jpg"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"/assets/user_data/docs/".$org_id."/".array_values($list)[$i]."\"><img src=\"/assets/user_data/docs/".$org_id."/".array_values($list)[$i]."\"></a></div>";
                                    continue;
                                }
                            }
                        }
                        
                        
                    }
                    ?>
                    
                    
                    <label id="labelDocUpload" for="docUpload" class="listDocItem addDoc">
                        <span class="doc_format">pdf, docx, jpg</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>
