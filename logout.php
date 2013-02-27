<?php
include 'init.php';

unset($_SESSION['auth_us']);
header("Location: /gallery/login.php");
die();
