
<?php

/* @var $this yii\web\View */

$this->title = 'Авторизация гражданина';
?>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<script src="/assets/js/ajax.js"> </script>

<section class="login-org">
    <div class="container">
<!-- "/index.php?r=registration-citizen%2Fcreate" -->

        <form method="post" id="ajax_form" action="">
            <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->getCsrfToken()?>">
            <p class="form-title">АВТОРИЗАЦИЯ ГРАЖДАНИНА</p>

            <div class="wrapper-textbox">

                <div id="email" class="hint email"></div>
                <img id="email" src="/assets/img/ico1.svg" alt="Некорректный E-mail" class="ico-in-textbox znak email" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="email" type="text" placeholder="E-mail">

            </div>

            <div class="wrapper-textbox">

                <div id="password" class="hint password">От 6 символов: цифры и/или английские буквы</div>
                <img id="password" src="/assets/img/ico2.svg" alt="Некорректный E-mail" class="ico-in-textbox tochki password" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="password" type="password" placeholder="Пароль">

            </div>
            
            <input type="button" id="login-citizen-button" value="Войти">
            
        </form>
        <a href="/index.php?r=forgot-password%2Findex" class="forgotPass">Забыли пароль?</a>
    </div>
</section>
