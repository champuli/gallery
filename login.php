<?php
include 'init.php';

//если пользователь залогинен, то отсылаем его на index.php
if(isset($_SESSION['auth_us']) && !empty($_SESSION['auth_us']))
{
    header("Location: /gallery/index.php"); die();
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
        header("Location: /gallery/index.php"); die();
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
        <link rel="stylesheet" type="text/css" href="style.css">
        <TITLE>Gallery Admin Area Login</TITLE>

    </HEAD>
    <BODY>
        <div id="main">
            <div id="header">
            </div>    
             <div id="content"> 
                <div id="login_form">
                    <form action="login.php" method="post">
                       Login <input type="text" value="" name="log" /><br>
                       Pass <input type="password" value="" name="pass" /><br>
                        <input type="submit" value="войти" />
                    </form>
                </div>
            </div>    
        </div>
    </BODY>
</HTML>
