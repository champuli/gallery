<?php
include 'init.php';
unlink(путь к файлу);


mysql_query("delete from `todo` where id=".$_GET['delete_id']);
header('Location:http://localhost/todo/todo.php');
exit;
?>

!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>DELETE pics</title>
</head>
<body>
</body>
</html>
