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
        <TITLE>Gallery Login</TITLE>

    </HEAD>
    <BODY>
        <form action="login.php" method="post">
            <input type="text" value="" name="log" />
            <input type="password" value="" name="pass" />
            <input type="submit" value="войти" />
        </form>


        <br />



    </BODY>
</HTML>