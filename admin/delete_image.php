<?php
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

$alb_id = mysql_query("SELECT album_id FROM `pics` where id=".$_GET['id']);
$show_alb_id = mysql_fetch_assoc($alb_id);

mysql_query("delete from `pics` where id=".$_GET['id']);

 echo "<pre>";
// print_r($_GET);

print_r($show_alb_id);

header('Location:/gallery/admin/show_all_album.php?album='.$show_alb_id['album_id']);
exit;

?>