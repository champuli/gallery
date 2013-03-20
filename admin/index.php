<?php
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

proverka_user();

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<h3>Menu</h3>
<br><a href="/gallery/admin/load_album.php" target="_blank">Создать альбом</a><br />
<br><a href="/gallery/admin/show_albums.php" target="_blank">Загрузить фото в альбом</a><br />
<br><a href="/gallery/admin/logout.php" target="_blank">Logout</a><br />
