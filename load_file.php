<?php
include 'init.php';
echo "<pre>";

$uploaddir = '/var/www/gallery/files/';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir.$_FILES['userfile']['name'])) 
{
    $filename = $_FILES['userfile']['name'];
    $image = new SimpleImage();
    $image->load($uploaddir.$_FILES['userfile']['name']);
    $image->resizeToHeight(800);
    $image->save($uploaddir.'/big/'.$_FILES['userfile']['name']);
    $image->resizeToHeight(100);
    $image->save($uploaddir.'/small/'.$_FILES['userfile']['name']);

    print "File is valid, and was successfully uploaded.";
} else {
    print "There some errors!";
}

echo "<pre>";
print_r($_FILES);

 


?>
<form enctype="multipart/form-data" action="/gallery/load_file.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
Send this file: <input name="userfile" type="file">
<input type="submit" value="Send File">
</form>