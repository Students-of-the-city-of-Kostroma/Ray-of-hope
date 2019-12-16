<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/css/normalize.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/assets/js/script2.js"></script>
	<script src="/assets/js/nav-mark2.js"></script>
    <script src="/assets/js/ajax.js"></script>
    <title>Авторизация организации</title>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/header.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/dialog-wrapper.php'; ?>
    <section class="login-org">
        <div class="container">
            <form method="post" id="ajax_form" action="">
                <p class="form-title">АВТОРИЗАЦИЯ ОРГАНИЗАЦИИ</p>
                <div class="wrapper-textbox">
                    <input name="email_or_inn" type="text" placeholder="E-mail или ИНН">
                </div>
                <div class="wrapper-textbox">
                    <input name="password" type="password" placeholder="Пароль">

                </div>
                <input type="button" id="login-button" value="Войти" />
            </form>
            <a href="" class="forgotPass">Забыли пароль?</a>
        </div>
    </section>
</body>