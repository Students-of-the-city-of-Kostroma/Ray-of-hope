
<?php

/* @var $this yii\web\View */

$this->title = 'Авторизация организации';
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
            <p class="form-title">АВТОРИЗАЦИЯ ОРГАНИЗАЦИИ</p>

            <div class="wrapper-textbox">

                <input name="email_or_inn" type="text" placeholder="E-mail или ИНН">

            </div>

            <div class="wrapper-textbox">

                <input name="password" type="password" placeholder="Пароль">

            </div>

            <input type="button" id="login-organisation-button" value="Войти" />
            
        </form>

        <a href="/index.php?r=forgot-password%2Findex" class="forgotPass">Забыли пароль?</a>
    </div>
</section>
