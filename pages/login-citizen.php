<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/css/normalize.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/assets/js/script.js"></script>
	<script src="/assets/js/nav-mark.js"></script>
    <script src="/assets/js/ajax.js"></script>
    <title>Авторизация гражданина</title>
</head>


<body>
    <?php include '/header.php'; ?>
    <?php include '/dialog-wrapper.php'; ?>
    <section class="login-org">
        <div class="container">
            <form method="post" id="ajax_form" action="">
                <p class="form-title">АВТОРИЗАЦИЯ ГРАЖДАНИНА</p>
                <div class="wrapper-textbox">
                    <input name="email" type="text" placeholder="E-mail">
                </div>
                <div class="wrapper-textbox">
                    <input name="password" type="password" placeholder="Пароль">

                </div>
                <input type="button" id="login-citizen-button" value="Войти" />
            </form>
            <a href="" class="forgotPass">Забыли пароль?</a>
        </div>
    </section>
</body>