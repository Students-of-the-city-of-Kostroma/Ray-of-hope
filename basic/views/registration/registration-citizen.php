
<?php

/* @var $this yii\web\View */

$this->title = 'Регистрация гражданина';
?>

<section class="registration-org">
    <div class="container">
        <form method="post" id="ajax_form" action="">
            <p class="form-title">РЕГИСТРАЦИЯ ГРАЖДАНИНА</p>
            <div class="wrapper-textbox">
                <div id="name" class="hint name"></div>
                <img id="name" src="/assets/img/ico1.svg" alt="Некорректное имя" class="ico-in-textbox znak name" onmouseover="showHint(this)" onmouseout="hideHint(this)">
                <input name="name" type="text" placeholder="Имя">
            </div>
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
            <div class="wrapper-textbox">
                <input name="password_2" type="password" placeholder="Повторите пароль">
            </div>
            <input type="button" id="registr-button" value="Зарегистрироваться">
        </form>
    </div>
</section>
