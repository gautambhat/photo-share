<?php
//var_dump($_FILES['photo']);
$target= "Uploads/";
$target = $target . basename($_FILES["photo"]["name"]);
ini_set('postmaxsize', '64M');
ini_set('uploadmaxfilesize', '64M');
$caption = $_POST['caption'];

if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)) 
{    // Connects to your Database
    include('connection.php');
        //Writes the information to the database
    $mysqli->query("INSERT INTO `Photos`(`caption`, `data`, `album_id`) VALUES ('".$caption."','".$target."',".$_POST['albumid'].")") or die($mysqli->error);
    //Tells you if its all ok
    //echo "The file ". basename( $_FILES['photo']['name']). " has been uploaded, and your information has been added to the directory";
    $res = $mysqli->query("SELECT name from Albums WHERE album_id=".$_POST['albumid']."");
    $res->data_seek(0);
    $r = $res->fetch_assoc();
    header('Location: viewalbum.php?albumid='.$_POST['albumid'].'&albumname='.$r['name']);
} else {
    //Gives and error if its not
    echo "Sorry, there was a problem uploading your file.";
}
?>
