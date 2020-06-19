<?php
aaa
require_once $_SERVER['DOCUMENT_ROOT']."/functions/functions.php";

if (isset($_SESSION['logged_org'])) : ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/css/normalize.css" rel="stylesheet">
    <link href="/assets/css/styles2.css" rel="stylesheet">
    <script src="/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/assets/js/nav-mark.js"></script>
    <title>Редактирование профиля</title>
</head>
<body>
    <?php include 'header2.php'; ?>
    <?php include '/dialog-wrapper.php'; ?>
    <div class="container">
    </div>
</body>
</html>
<?php else : ?>
<?php header("Location: /login/org"); ?>
<?php endif; ?>