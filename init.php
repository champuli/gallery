<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

include('lib/simple_image.php');

session_start();

$link = mysql_connect("localhost", 'root', "root")
        or die("Could not connect: " . mysql_error());

mysql_select_db('gallery', $link) or die('Can\'t use bb : ' . mysql_error());

function proverka_user()
{
    if (isset($_SESSION['auth_us']) && !empty($_SESSION['auth_us']))
    {
    } 
    else 
    {
        header("Location: /gallery/login.php");die();
    } 
}
?>
