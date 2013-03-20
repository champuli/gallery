<?php
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

unset($_SESSION['auth_us']);
header("Location: /gallery/admin/login.php");
die();
