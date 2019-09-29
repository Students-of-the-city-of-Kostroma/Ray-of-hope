<div class="nav-wrapper">
    <div class="navbar">
	<a href="#" class="logo_link"><img class="logo" src="../assets/img/logo_header2.png" alt="Луч надежды"></a>
	<div class="nav-links">
        <a id="nav-avatar" class="avatar-link <?php  if (stripos($_SERVER['REQUEST_URI'], "/organisation/")!==false && $_SERVER['REQUEST_URI']=="/organisation/".$_SESSION['logged_org']) {echo "active";} ?>" href="https://rayofhope-opensource.000webhostapp.com/organisation/<?php echo $_SESSION['logged_org']?>"><img class="avatar" src="https://rayofhope-opensource.000webhostapp.com/user_data/avatar/<?php
            if (is_null($_SESSION['org_avatar'])){
                echo "noavatar";
            }
            else{
                echo $_SESSION['logged_org'];
            }
        ?>.jpg" alt="Мой профиль"></a>
		<li id="nav-feed" class="nav-link">
			<a href="https://rayofhope-opensource.000webhostapp.com/feed">Лента</a>
		</li>
		<li id="nav-message" class="nav-link">
			<a href="#">Сообщения</a>
        </li>
        <li id="nav-org" class="nav-link <?php if (stripos($_SERVER['REQUEST_URI'], "/organisation/")!==false && $_SERVER['REQUEST_URI']!="/organisation/".$_SESSION['logged_org']) {echo "active";} ?>">
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
			<ul class="sub-menu">
                <a href="#">Кооментарии</a>
                <a href="#">Закладки</a>
                <a href="#">F.A.Q</a>
                <a href="#">Настройки</a>
                <a href="#">Выход</a>
            </ul>
		</li>
    </div>
    <input class="nav-search" type="search" placeholder="Поиск">
    </div>
</div>