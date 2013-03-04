<?php 
ini_set('display_errors',1);
error_reporting(E_ALL);

include('lib/simple_image.php');

$link = mysql_connect("localhost", 'root', "root")
        or die("Could not connect: " . mysql_error());

mysql_select_db('gallery', $link) or die('Can\'t use bb : ' . mysql_error());

$s = array();
$all_show = array();

$show_alb = mysql_query("SELECT * FROM `album`");

while($s = mysql_fetch_assoc($show_alb))
{
    $all_show[] = $s;
}

$r = array();
$rand = array();
$rand_pic = mysql_query("SELECT * FROM `pics` order by rand() limit 1");

while($r = mysql_fetch_assoc($rand_pic))
{
    $rand[] = $r;
}

// echo "<pre>";
// print_r($rand);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Album User Area</title>
</head>
<body>
<div id="main">
    <div id="content"> 
       <?php foreach ($rand as $r_k => $r_v): ?>
            <img  width="400px" src="http://localhost/gallery/files/<?php echo $r_v['path_big']; ?>" />
            <?php endforeach; ?>

       <form enctype="multipart/form-data" action="/gallery/user_albums.php" method="get" > 
            
            <?php foreach ($all_show as $nu => $val): ?>
            <div class="album_cover">
                <a href="http://localhost/gallery/foto_in_user_albums?album=<?php echo $val['id']; ?>"><?php echo $val['name']; ?></a><br />
                <img src="http://localhost/gallery/files/<?php echo $val['path_oblogka']; ?>" />
            </div>
            <?php endforeach; ?>
            <br /><br />
    </div> 

</div>
</body>
</html>