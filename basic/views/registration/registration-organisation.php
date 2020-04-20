
<?php

/* @var $this yii\web\View */

$this->title = 'Регистрация организации';
?>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<script src="/assets/js/ajax.js"> </script>

<section class="registration-org">
    <div class="container">
        <form method="post" id="ajax_form" action="">
        <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->getCsrfToken()?>">
            <p class="form-title">РЕГИСТРАЦИЯ ОРГАНИЗАЦИИ</p>
            <div class="wrapper-textbox">
                <div id="name" class="hint name"></div>
                <img id="name" src="/assets/img/ico1.svg" alt="Некорректное название" class="ico-in-textbox znak name" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="name" type="text" placeholder="Название">
            </div>
            <div class="wrapper-textbox">
                <div id="email" class="hint email"></div>
                <img id="email" src="/assets/img/ico1.svg" alt="Некорректный E-mail" class="ico-in-textbox znak email" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="email" type="text" placeholder="E-mail">
            </div>
            <div class="wrapper-textbox">
                <div id="INN" class="hint INN"></div>
                <img id="INN" src="/assets/img/ico1.svg" alt="Некорректный ИНН" class="ico-in-textbox znak INN" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="INN" type="text" placeholder="ИНН">
            </div>
            <div class="wrapper-textbox">
                <div id="password" class="hint password">От 6 символов: цифры и/или английские буквы</div>
                <img id="password" src="/assets/img/ico2.svg" alt="Некорректный E-mail" class="ico-in-textbox tochki password" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="password" type="password" placeholder="Пароль">
            </div>
            <div class="wrapper-textbox">
                <input name="password_2" type="password" placeholder="Повторите пароль">
            </div>
            <input type="button" id="registr-organisation-button" value="Зарегистрироваться">
        </form>
    </div>
</section>
