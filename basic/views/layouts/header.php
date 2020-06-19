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

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/css/normalize.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="assets/js/nav-mark2.js"></script>
    <script src="assets/js/script2.js"></script>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
</head>
<link rel="shortcut icon" href="/assets/img/ray_of_hope.ico" type="image/x-icon">
<body>
<?php $this->beginBody() ?>



<div class="navbar-wrapper">
    <div class="navbar">
	    <a id="avatar-link" href="index.php?r=site%2Findex" style="">  <!-- $_SERVER['HTTP_HOST']."/#header" -->
	        <svg class="logo" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 1999 1466" xmlns:xlink="http://www.w3.org/1999/xlink">
	            <defs>
	        <style type="text/css">
	       .hand {fill:white}
	       .heart {fill:white;fill-rule:nonzero}
	       </style>
	       </defs>
	       <path class="hand" d="M1598 883c5,22 13,197 8,216 -6,21 -29,54 -41,78 -46,96 -41,150 -154,201 -35,16 -90,29 -134,47 -14,5 -35,11 -24,28 8,8 43,-11 70,-20 88,-31 124,-31 193,-100 30,-30 45,-87 64,-129 24,-54 54,-80 54,-146 0,-52 -8,-106 -9,-160 -1,-27 -18,-51 -50,-37 -57,24 -53,156 -40,166 33,24 9,-52 22,-99 6,-21 16,-50 41,-45zm-1195 -1c60,-1 40,133 44,141 6,14 19,7 22,-4 4,-12 4,-55 3,-69 -4,-34 -21,-89 -60,-92 -52,-5 -36,72 -40,111 -16,163 -6,118 49,236 37,81 37,128 126,179 54,30 111,39 168,63 50,21 38,-8 26,-15 -27,-14 -83,-29 -114,-40 -90,-30 -130,-62 -162,-143 -51,-131 -81,-121 -73,-226 2,-25 6,-127 11,-141zm1139 212c3,27 -35,62 -52,95 -9,18 -16,36 -29,46 -6,5 -20,11 -24,14 -23,21 17,36 54,-11 11,-14 17,-33 27,-49 12,-20 56,-68 49,-97 -4,-18 -27,-27 -49,-25 -41,5 -79,73 -126,104 -137,90 -283,75 -343,263 -11,35 11,44 21,17 7,-22 10,-34 21,-54 44,-81 85,-101 167,-135 144,-59 137,-59 231,-151 15,-14 26,-26 53,-17zm-1080 0c35,-27 66,64 173,120 124,65 213,63 274,184 11,20 14,34 21,54 9,23 33,17 21,-16 -65,-196 -215,-178 -342,-265 -60,-41 -84,-97 -125,-103 -25,-4 -49,7 -51,26 -5,28 39,78 51,99 10,17 15,34 27,48 37,44 74,28 53,9 -22,-20 -18,9 -55,-61 -11,-21 -48,-69 -51,-81 -4,-19 1,-11 4,-14zm1286 -503l-279 107c-14,12 -5,30 17,26l278 -107c16,-14 3,-31 -16,-26zm-985 -157c13,-14 -3,-37 -16,-67l-58 -132c-7,-16 -19,-60 -41,-46 -17,10 8,51 14,65l58 132c8,19 17,61 43,48zm612 -429c-25,-15 -29,5 -38,26 -11,26 -69,145 -62,158 4,8 15,11 24,5 7,-5 11,-17 14,-26 15,-33 66,-141 62,-163zm-128 248c-7,3 -4,-6 -16,22 -9,23 -68,148 -66,160 2,10 13,15 23,11 11,-5 41,-84 49,-102 7,-19 14,-36 22,-53 4,-8 11,-20 9,-28 -2,-12 -11,-15 -21,-10zm122 250c-14,9 -89,96 -109,119 -6,7 -16,14 -16,25 2,14 14,17 25,10 7,-4 31,-32 37,-39l72 -80c0,-1 29,-26 4,-36 -13,-6 -12,1 -13,1zm-391 36c10,-18 7,-123 8,-155 0,-10 1,-17 -5,-23 -4,-6 -14,-8 -21,-3 -13,9 -8,80 -8,100 -1,59 -11,90 26,81zm-533 -120c-20,13 10,32 18,39l73 66c7,6 29,32 45,23 24,-15 -27,-50 -55,-75 -11,-10 -25,-22 -37,-32 -11,-10 -26,-33 -44,-21zm-437 110c-32,21 39,40 56,46 17,6 77,34 91,25 31,-21 -46,-41 -59,-46 -16,-6 -74,-34 -88,-25zm560 -509c-19,9 5,48 12,64 7,17 20,61 41,52 20,-9 -5,-51 -12,-66 -6,-15 -18,-61 -41,-50zm-338 600c-22,21 28,32 45,38 16,6 56,26 67,16 28,-23 -41,-39 -76,-53 -27,-10 -27,-10 -36,-1zm1651 -59c20,2 84,-23 105,-33 14,-6 19,-22 3,-28 -10,-4 -56,15 -69,20 -27,11 -54,11 -39,41zm-921 -363c-10,15 -7,42 -8,64 0,16 -7,59 22,46 15,-7 10,-43 11,-62 0,-28 11,-53 -25,-48zm506 207c-2,1 -52,45 -47,62 10,36 55,-25 59,-30 21,-22 12,-46 -12,-32zm-769 254c13,-19 1,-25 -14,-39 -54,-51 -76,-24 -32,14 24,21 27,29 46,25zm-224 43c-17,-10 -91,-42 -73,-2 1,3 79,55 73,2z"></path>
	       <path class="heart" d="M715 893c0,49 39,109 89,162 74,80 169,145 196,145 26,0 121,-65 195,-145 50,-53 89,-113 89,-162 0,-37 -15,-71 -39,-95 -25,-25 -58,-40 -96,-40 -31,0 -59,11 -81,25 -31,20 -49,54 -54,61 -5,7 -9,11 -14,11 -6,0 -12,-7 -15,-11 -3,-5 -24,-41 -55,-61l-1 0c-21,-14 -49,-25 -79,-25 -37,0 -71,15 -96,40 -24,24 -39,58 -39,95zm68 182c-55,-58 -98,-124 -98,-182 0,-45 19,-86 49,-116 29,-30 70,-48 116,-48 37,0 69,12 95,29 1,0 1,0 1,1 23,14 41,33 53,50 12,-17 30,-35 53,-50 27,-17 60,-30 97,-30 46,0 87,18 117,48 29,30 48,71 48,116 0,58 -43,124 -97,182 -79,85 -185,154 -217,154 -33,0 -139,-69 -217,-154z"></path>
	       </svg> 
</a>
	<div class="nav-links">
		<li class="nav-link">
			<a id="about-button" href="/index.php?r=site%2Findex">О нас</a>
		</li>
		<li id="login" class="nav-link sub">
			<a>Вход</a>
			<ul class="sub-menu">
				<a href="/index.php?r=authorization%2Fcitizen">Гражданин</a>
				<a href="/index.php?r=authorization%2Forganisation">Организация</a>
			</ul>
		</li>
		<li id="reg" class="nav-link sub">
			<a>Регистрация</a>
			<ul class="sub-menu">
				<a href="/index.php?r=registration%2Fcitizen">Гражданин</a>
				<a href="/index.php?r=registration%2Forganisation">Организация</a>
			</ul>
		</li>
	</div>
</div>
</div>

<?= $content ?>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>
