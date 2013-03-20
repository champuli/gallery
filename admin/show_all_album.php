<?php
include 'init.php';

if(isset($_POST) && !empty($_POST))
{
    $uploaddir = '/var/www/gallery/files/';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$_FILES['userfile']['name'])) 
    {
        $filename = $_FILES['userfile']['name'];
        $image = new SimpleImage();
        $image->load($uploaddir.$_FILES['userfile']['name']);
        $image->resizeToHeight(800);
        $image->save($uploaddir.'big/'.$_FILES['userfile']['name']);
        $image->resizeToHeight(100);
        $image->save($uploaddir.'small/'.$_FILES['userfile']['name']);

        print "File is valid, and was successfully uploaded.";

        $opis= $_POST['opis'];
        $path_file_big = '/big/'.$_FILES['userfile']['name'];
        $path_file_small = '/small/'.$_FILES['userfile']['name'];
        
        $que = mysql_query("INSERT INTO `pics`(`album_id`, `path_big`, `path_small`, `opis`) VALUES ('{$_POST['album']}', '$path_file_big', '$path_file_small', '{$_POST['opis']}')");
    } else {
        print "There some errors!";
    }
}

$foto = mysql_query("SELECT * FROM `pics` WHERE `album_id` = '{$_REQUEST['album']}'");

$show_all_foto_in_album = array();
while($show_foto = mysql_fetch_assoc($foto))
{
    $show_all_foto_in_album[] = $show_foto;
}

$c = 0;

// echo "<pre>";
// print_r($show_all_foto_in_album);

?>

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Load Photos To Album</title>
</head>

<body>
    <div id="main">
        <div id="header">
            <a href="/gallery/load_album.php" target="_blank">Создать альбом</a>
            <a href="/gallery/show_albums.php" target="_blank">Загрузить фото в альбом</a>
            <a href="/gallery/logout.php" target="_blank" id="logout">Logout</a>
        </div>

        <div id="content"> 
            <form enctype="multipart/form-data" action="/gallery/show_all_album.php?album=<?php echo $_REQUEST['album'] ?>"  method="post">
                                <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                <br>файл:       <input name="userfile" type="file"><br />
                <br> Описание   <input type="text" value="" name="opis" /><br />
                <br>            <input type="submit" value="добавить фотографии" /><br />

                                <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>">
                <br>

             
                <?php foreach ($show_all_foto_in_album as $nm => $vl): ?>
                    <div class="photo_and_delete_container">

                        <div class="foto_container">
                            <a href="http://localhost/gallery/files/<?php echo $vl['path_big']; ?>" target="_blank"  >
                                <img border="0" src="http://localhost/gallery/files/<?php echo $vl['path_small']; ?>">
                            </a>
                        </div>

                        <div class="delete_container">
                            <a href="delete_image.php?id=<?php echo $vl['id']; ?>" target="_blank">удалить</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </form>
        </div>           
    </div> 
     
</body>
</html>