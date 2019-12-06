<?php
require_once "../functions/functions.php";
require_once "../functions/classes/Database.php";
$db=new Database();
$activityList=$db->getActivityList();

if (isset($_SESSION['logged_org'])) : ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../assets/css/normalize.css" rel="stylesheet">
    <link href="../assets/css/styles2.css" rel="stylesheet">
    <script src="../assets/js/jquery-3.4.1.min.js"></script>
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="../assets/js/nav-mark.js"></script>
    <script src="../assets/js/edit_org.js"></script>
    <title>Редактирование профиля</title>
</head>
<body>
    <?php include 'header2.php'; ?>
    <?php include '../dialog-wrapper.php'; ?>
    <div class="container">
        <div class="frame editProfile">
            <div class="info">
                <div class="avatar-name-activity">
                    <div class="avatar-wrapper">
                        <div class="avatar-doublewrapper"><img src="<?php echo $_SESSION['org_avatar']; ?>" alt="" class="avatar"></div>
                        <input name="file" id="file" type="file" class="upload_photo">
                        <label for="file" class="upload_photo"></label> 
                    </div>  
                    <div class="name-activity">
                        <div class="name wrapper">
                            <div class="imput-title">Название</div>
                            <input name='name' class='name' type='text' placeholder='Введите название...' value="<?php echo $_SESSION['org_name']; ?>">
                        </div>
                        <div class="activity-wrapper">
                            <select required name="activity" class="activity" value="<?php echo $_SESSION['org_activity']; ?>">
                                <?php 
                                    if (is_null($_SESSION['org_activity'])){
                                        echo '<option disabled selected value="">Вид деятельности</option>';
                                    }
                                    else{
                                        echo '<option disabled value="">Вид деятельности</option>';
                                    }
                                    foreach ($activityList as $activity){
                                        if ($activity['id'] == $_SESSION['org_activity']){
                                            echo '<option selected value="'.$activity['id'].'">'.$activity['name'].'</option>';
                                            continue;
                                        }
                                        echo '<option  value="'.$activity['id'].'">'.$activity['name'].'</option>';
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
                    <input value="<?php if (!(is_null($_SESSION['org_city_name']))) {echo $_SESSION['org_city_name'];} ?>" id_city="<?php echo $_SESSION['org_city']; ?>" id="city" autocomplete="off" name="city" class="city" type="text" placeholder="Введите город...">
                </div>            
                <div class="description wrapper">
                        <div class="imput-title">Описание</div>
                        <textarea name="description" class="description" type="text" placeholder="Введите описание..." ><?php echo $_SESSION['org_description']; ?></textarea>
                </div>                
                <div class="phone wrapper">
                        <div class="imput-title">Телефон</div>
                        <input value="<?php if (!(is_null($_SESSION['number_phone']))) echo $_SESSION['number_phone']; ?>" id="phone" name="phone" class="phone" type="number" placeholder="Введите номер телефона...">
                </div>
                <div class="address wrapper">
                    <div class="dropdown">
                        <div class="address-list" style="display: none;"></div>
                    </div>
                    <div class="imput-title" style="z-index: 1;">Адрес</div>
                    <input value="<?php if(!is_null($_SESSION['address'])) {echo $_SESSION['address'];} ?>" id="address" name="address" class="address" type="text" placeholder="Введите адрес...">
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
                        if (isset($_SESSION['org_docs'])){
                            
                        $dir  = '../user_data/docs/'.$_SESSION['logged_org'];
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
                        $org_id=$_SESSION['logged_org'];
                        
                        for ($i=0;$i<count($list);$i++){
                            if (!is_dir("../user_data/docs/".$org_id."/".array_values($list)[$i])){
                                
                                $path_parts = pathinfo("../user_data/docs/".$org_id."/".array_values($list)[$i]);
                                if ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"../user_data/docs/".$org_id."/".array_values($list)[$i]."\"><img src=\"../user_data/docs/".$org_id."/preview/".$path_parts['filename'].".png\"></a></div>";
                                    continue;
                                }
                                if ($path_parts['extension']=="jpg"){
                                    echo "<div class=\"listDocItem\"><a target=\"_blank\" href=\"../user_data/docs/".$org_id."/".array_values($list)[$i]."\"><img src=\"../user_data/docs/".$org_id."/".array_values($list)[$i]."\"></a></div>";
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
<?php else : ?>
<?php header("Location: registration-organization.php"); ?>
<?php endif; ?>