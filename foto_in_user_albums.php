<?php 
ini_set('display_errors',1);
error_reporting(E_ALL);

include('lib/simple_image.php');

$link = mysql_connect("localhost", 'root', "root")
        or die("Could not connect: " . mysql_error());

mysql_select_db('gallery', $link) or die('Can\'t use bb : ' . mysql_error());

$foto = mysql_query("SELECT * FROM `pics` WHERE `album_id` = '{$_REQUEST['album']}'");

$show_all_foto_in_album = array();
$kol_fotok = mysql_num_rows($foto);
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

<link rel="stylesheet" href="/gallery/fancy/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" /> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="/gallery/fancy/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="/gallery/fancy/jquery.fancybox-1.3.4/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="/gallery/fancy/jquery.fancybox-1.3.4/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    /* This is basic - uses default settings */
    
    $("a.single_image").fancybox({
        titlePosition: 'inside'
    });
    
});
</script>



<title>All Photos In Album</title>
</head>
<body>
    <div id="main">
        
        <div id="content"> 
            
         <form enctype="multipart/form-data" action="/gallery/foto_in_user_album.php?album=<?php echo $_REQUEST['album'] ?>"  method="post">
            <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>">
            <br><a href="/gallery/user_albums.php" target="_blank">вернуться ко всем альбомам</a><br />
            <br>
            
            <?php foreach ($show_all_foto_in_album as $nm => $vl): ?>
            <?php $c++; ?>
            <a href="/gallery/files/<?php echo $vl['path_big']; ?>" class="single_image" rel="group1" title= "<?php echo $vl['opis']; ?>" >
            <img  class="single_image_div" border="0"  alt="" src="/gallery/files/<?php echo $vl['path_small']; ?>">
                <?php
                if ($c == 4){
                    echo "<br>";
                    $c = 0;
                }
                ?>
            <?php endforeach; ?></a><br>
           
           <?php if($kol_fotok<= 0)
           { echo "В альбоме еще нет фотографий";}?>
            
            </form>
        </div> 

    </div>
</body>
</html>
