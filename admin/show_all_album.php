<?php
define('SITE_PATH',dirname(dirname(__FILE__)));
include SITE_PATH.'/init.php';

$array_poslednih_id = array();

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

        $opis= $_POST['opis'];
        $path_file_big = '/big/'.$_FILES['userfile']['name'];
        $path_file_small = '/small/'.$_FILES['userfile']['name'];
        
        $que = mysql_query("INSERT INTO `pics`(`album_id`, `path_big`, `path_small`, `opis`) VALUES ('{$_POST['album']}', '$path_file_big', '$path_file_small', '{$_POST['opis']}')");

        $select_last_pic_id = mysql_query("SELECT LAST_INSERT_ID() FROM `pics`");
        $show_last_pic_id = mysql_fetch_assoc($select_last_pic_id);
        
        foreach ($show_last_pic_id as $show_k => $show_val)
        {
          $array_poslednih_id[] = $show_val;
        }     
    } 
}

$foto = mysql_query("SELECT * FROM `pics` WHERE `album_id` = '{$_REQUEST['album']}'");

$show_all_foto_in_album = array();
while($show_foto = mysql_fetch_assoc($foto))
{
    $show_all_foto_in_album[] = $show_foto;
}

$c = 0;

$t =  mysql_query("SELECT * FROM `tags`");
$show_all_tag = array();
while($show_tag = mysql_fetch_assoc($t))
{
    $show_all_tag[] = $show_tag;
}

$t =  mysql_query("SELECT * FROM `tags`");
$show_all_tag = array();
while($show_tag = mysql_fetch_assoc($t))
{
    $show_all_tag[] = $show_tag;
}

$array_poslednih_tag_id = array();

if(isset($_POST) && !empty($_POST))
{

  $str_lower = strtolower($_POST['tags']);
  $single_tag = explode(",",$str_lower);
  $unique_tags = array_unique($single_tag);

  foreach ($unique_tags as $singl_k => $singl_val)
  { 
    $found_tag = false;
    foreach ($show_all_tag as $k_tag => $val_tag)
    { 
      if (trim($singl_val) == $val_tag['tags_name'])
      {
        $found_tag = true;
        foreach ($array_poslednih_id as $arr_last_id_key => $arr_last_id_val) 
        {
          $zapis_v_imagetags_table = mysql_query("INSERT INTO `image_tags_id`(`image_id`, `tag_id`) VALUES ('$arr_last_id_val', '{$val_tag['id']}')"); 
        }
      } 
    }
    if (!$found_tag)
    {
      $singl_val= trim($singl_val);
      $req_tag = mysql_query("INSERT INTO `tags`(`tags_name`) VALUES ('$singl_val')");
      $select_last_tag_id = mysql_query("SELECT LAST_INSERT_ID() FROM `tags`");
      $show_last_tag_id = mysql_fetch_assoc($select_last_tag_id);      
      foreach ($show_last_tag_id as $show_tag_k => $show_tag_val)
      {
          $array_poslednih_tag_id[] = $show_tag_val;
          $zapis_v_imagetags_table_new_tag = mysql_query("INSERT INTO `image_tags_id`(`image_id`, `tag_id`) VALUES ('$show_val', '$show_tag_val')"); 
      }

    }
  }
}

$t =  mysql_query("SELECT * FROM `tags`");
$show_all_tag = array();
while($show_tag = mysql_fetch_assoc($t))
{
    $show_all_tag[] = $show_tag;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/gallery/style.css">
<title>Load Photos To Album</title>
</head>

<body>
    <div id="main">
        <div id="header">
            <a href="/gallery/admin/load_album.php" target="_blank">Создать альбом</a>
            <a href="/gallery/admin/show_albums.php" target="_blank">Загрузить фото в альбом</a>
            <a href="/gallery/admin/logout.php" target="_blank" id="logout">Logout</a>
        </div>

        <div id="content"> 
            <form enctype="multipart/form-data" action="/gallery/admin/show_all_album.php?album=<?php echo $_REQUEST['album'] ?>"  method="post">
                                <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                <br>файл:       <input name="userfile" type="file"><br />
                <br> Описание   <input type="text" value="" name="opis" /><br />
                <br>tags        <input type="text" name="tags" /><br /> 
                <br>            <input type="submit" value="добавить фотографии" /><br />

                                <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>">
                <br>

             
                <?php foreach ($show_all_foto_in_album as $nm => $vl): ?>
                    <div class="photo_and_delete_container">

                        <div class="foto_container">
                            <a href="/gallery/files/<?php echo $vl['path_big']; ?>" target="_blank"  >
                                <img border="0" src="/gallery/files/<?php echo $vl['path_small']; ?>">
                            </a>
                        </div>

                        <div class="delete_container">
                            <a href="/gallery/admin/delete_image.php?id=<?php echo $vl['id']; ?>" target="_blank">удалить</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </form>
        </div>           
    </div> 
     
</body>
</html>