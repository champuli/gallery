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

$que_search_pic_on_id_tag = mysql_query("
    select 
      tags_name, count(*) cnt 
    from 
      tags 
    inner join image_tags_id 
    on 
      tags.id = image_tags_id.tag_id  
    inner join pics 
    on 
      pics.id = image_tags_id.image_id 
    group by tags_name
    ");
  
  while($pic_by_tag_assoc = mysql_fetch_assoc($que_search_pic_on_id_tag))
  {
    $show_pic_by_tag[] = $pic_by_tag_assoc;
  }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>album admin area</title>
</head>
<body>
        <div id="main">
            <div id="content">  
                <div class="user_albums">

                <?php foreach ($all_show as $nu => $val): ?>
                <div class="album_cover">
                    <a href="/gallery/foto_in_user_albums?album=<?php echo $val['id']; ?>"><?php echo $val['name']; ?></a><br />
                    <img src="/gallery/files/<?php echo $val['path_oblogka']; ?>" />
                </div>
                <?php endforeach; ?>
                </div>

                <div class="user_tags">
                    <?php foreach ($show_pic_by_tag as $show_pic_by_tag_v): ?>
                    <a href="/gallery/show_foto_by_tag.php?search_tags=<?php echo $show_pic_by_tag_v['tags_name']; ?>" style="font-size:<?php echo 10+($show_pic_by_tag_v['cnt']*4); ?>px">
                        <?php echo $show_pic_by_tag_v['tags_name']; ?>
                    </a>
                    <?php endforeach; ?>            
                </div>    
            </div> 
        </div>
</body>
</html>