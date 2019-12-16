<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets;


AppAsset::register($this);
?>

<?php  $this->beginContent('@app/views/layouts/header.php') ?>

<?php $this->beginPage() ?>

<body>
<?php $this->beginBody() ?>


<div class="dialog-wrapper">
    <dialog class="dialog-window">
        <span class="dialog-title"></span>
        <span class="dialog-message"></span>
        <button class="dialog-ok-button" onclick="hide_dialog()">Ок</button>
    </dialog>
</div>



<?= $content ?>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>

<?php $this->endContent(); ?>


