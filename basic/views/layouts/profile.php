<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\OrganisationDB;
use app\models\UserDB;
use app\assets;



if (!isset(Yii::$app->session["id"])) {
    return  Yii::$app->response->redirect("/");
}

else {

$id = Yii::$app->session->get("id");
$email = Yii::$app->session->get("email");
$type = Yii::$app->session->get("type");


$avatar = UserDB::find()
        ->where(['id' => $id])
        ->all();

if ($avatar[0]["avatar"] !== NULL) {
    $avatar = "/assets/user_data/avatar/".$avatar[0]["avatar"];
}
else {
    $avatar = "/assets/user_data/avatar/noavatar.jpg";
}

$thisOrg = OrganisationDB::find()
        ->where(['user_id' => $id])
        ->all();



AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="/assets/css/normalize.css" rel="stylesheet">
        <link href="/assets/css/styles2_copy4.css" rel="stylesheet">
        <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
     
        

        <title><?= Html::encode($this->title) ?></title>
    </head>
    <link rel="shortcut icon" href="/assets/img/ray_of_hope.ico" type="image/x-icon">
<body>
<?php $this->beginBody() ?>

<div class="nav-wrapper">
    <div class="navbar">
	<a href="/" class="logo_link"><img class="logo" src="/assets/img/logo_header2.png" alt="Луч надежды"></a>
	<div class="nav-links">
        <a id="nav-avatar" class="avatar-link <?php  if ($id !== NULL) {echo "active";} ?>" href=""><img class="avatar" src="<?php echo $avatar; ?>" alt="Мой профиль"></a>
		<li id="nav-feed" class="nav-link">
			<a href="#">Лента</a>
		</li>
		<li id="nav-message" class="nav-link">
			<a href="#">Сообщения</a>
        </li>
        <li id="nav-org" class="nav-link <?php if ($id !== NULL) {echo "active";} ?>">
			<a href="#">Организации</a>
        </li>
        <li id="nav-answer" class="nav-link">
			<a href="#">Ответы</a>
        </li>
        <li id="nav-favorite" class="nav-link">
			<a href="#">Любимые</a>
		</li>
		<li id="nav-more" class="nav-link sub">
			<a href="#">Ещё</a>
			<ul class="sub-menu" >
                <a href="#">Коментарии</a>
                <a href="#">Закладки</a>
                <a href="#">F.A.Q</a>
                <a href="#">Настройки</a>
                <a href="/index.php?r=session%2Fdestroy">Выход</a>
            </ul>
		</li>
    </div>
    <input class="nav-search" type="search" placeholder="Поиск">
    </div>
</div>

<script src="/assets/js/header.js"></script>

<div class="dialog-wrapper">
    <dialog class="dialog-window">
        <span class="dialog-title"></span>
        <span class="dialog-message"></span>
        <button class="dialog-ok-button" onclick="hide_dialog()">Ок</button>
    </dialog>
</div>

<?= $content ?>

<?php $this->endBody() ?>

<script type="text/javascript" src="/assets/js/nav-mark2.js"></script>
<script type="text/javascript" src="/assets/js/jquery.maskedinput2.min.js"></script>
<script type="text/javascript" src="/assets/js/newpost26.js"></script>
<script type="text/javascript" src="/assets/js/profile_org.js"></script>
<script src="/assets/js/post_list.js"></script>
</body>
</html>

<?php } ?>

<?php $this->endPage() ?>
