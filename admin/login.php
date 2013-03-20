<?php
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

//если пользователь залогинен, то отсылаем его на index.php
if(isset($_SESSION['auth_us']) && !empty($_SESSION['auth_us']))
{
    header("Location: /gallery/admin/index.php"); die();
}

//если форма была отправлена

if(isset($_POST['log']) && !empty($_POST['log']))
{
    $hs = md5($_POST['pass']);
    $qu = mysql_query("SELECT * FROM `users` WHERE login LIKE '{$_POST['log']}' AND pass LIKE '{$hs}'");
    $res = mysql_num_rows($qu);
    if ($res > 0)
    {
        $_SESSION['auth_us'] = $_POST['log'];
        header("Location: /gallery/admin/index.php"); die();
    }
    else
    {
        echo "Неправильный логин и/или пароль";
    }
}


?>
<!DOCTYPE HTML>
<HTML>
    <HEAD><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <link rel="stylesheet" type="text/css" href="/gallery/style.css">
        <TITLE>Gallery Admin Area Login</TITLE>
    </HEAD>
    <BODY>
        <div id="main">
            <div id="header">
                <a href="/gallery/admin/user_albums.php" target="_blank">user albums</a>
            </div>    
            <div id="content"> 
                <div id="login_form">
                    <form action="login.php" method="post">
                       <table width="350">
                       <tr>
                           <td>Login:</td><td><input type="text" value="" name="log" /></td>
                       </tr>
                       <tr>
                           <td>Password: </td><td><input type="password" value="" name="pass" /><td>
                       </tr>
                       <tr>
                           <td colspan="2"><input type="submit" value="войти" /></td>
                       </tr>
                    </form>
                </div>
            </div>
        </div>
    </BODY>
</HTML>
