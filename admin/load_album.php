<?php 
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

if(isset($_POST) && !empty($_POST))
{
    $uploaddir = '/var/www/gallery/files/';
    if (move_uploaded_file($_FILES['album_cover']['tmp_name'], $uploaddir.$_FILES['album_cover']['name'])) 
    {
        $filename = $_FILES['album_cover']['name'];
        $image = new SimpleImage();
        $image->load($uploaddir.$_FILES['album_cover']['name']);
        $image->resizeToHeight(150);
        $image->save($uploaddir.'/album_cover/'.$_FILES['album_cover']['name']);

        $name = $_POST['name_album'];
        $opis= $_POST['opis'];
        $path_oblogka = 'album_cover/'.$_FILES['album_cover']['name'];
        $qu = mysql_query("INSERT INTO `album`(`name`, `opis`, `path_oblogka`) VALUES ('$name','$opis','$path_oblogka')");

        print "File is valid, and was successfully uploaded.";
    } else {
        print "There some errors!";
    }
}



// echo "<pre>";
// print_r($_POST);
// echo "<pre>";
// print_r($_FILES);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/gallery/style.css">
<title>Load Album</title>
</head>
<body>
<div id="main">
    <div id="header">
        <a href="/gallery/admin/load_album.php" target="_blank">Создать альбом</a>
        <a href="/gallery/admin/show_albums.php" target="_blank">Загрузить фото в альбом</a>
        <a href="/gallery/admin/logout.php" target="_blank" id="logout">Logout</a>
    </div>

    <div id="content"> 
        <form enctype="multipart/form-data" action="/gallery/admin/load_album.php" method="post">
           <br> Название альбома <input type="text" value="" name="name_album" /><br />
           <br> Описание <input type="text" value="" name="opis" /><br />
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
           <br> Обложка альбома <input name="album_cover" type="file"><br />
           <br> <input type="submit" value="создать альбом" /><br />
          
        </form>
    </div> 

</div>
</body>
</html>

