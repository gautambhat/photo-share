<?php
session_start();
include('connection.php');
$res = $mysqli->query("SELECT user_id from Albums where album_id=".$_GET['albumid']."") or die($mysqli->error);
$res->data_seek(0);
$r = $res->fetch_assoc();
if($r['user_id'] == $_SESSION['UID'])
{
  $mysqli->query("DELETE FROM `Likes` WHERE photo_id IN (SELECT photo_id FROM Photos WHERE album_id=".$_GET['albumid'].")") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Comments` WHERE photo_id IN (SELECT photo_id FROM Photos WHERE album_id=".$_GET['albumid'].")") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Tagged` WHERE photo_id IN (SELECT photo_id FROM Photos WHERE album_id=".$_GET['albumid'].")") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Photos` WHERE album_id=".$_GET['albumid']."") or die($mysqli->error);
  $pathq = $mysqli->query("SELECT p.data from Photos p, Albums a WHERE a.album_id = p.album_id AND p.album_id = ".$_GET['albumid']."")or die($mysqli->error);
  for($i=0;$i<$pathq->num_rows;$i=$i+1)
  {
    $pathq->data_seek($i);
    $path = $pathq->fetch_assoc();
    echo $path['data'];
    if(!unlink($path['data']))
      echo "coudn't delete";
    else echo "deleted.";
  }
  $mysqli->query("DELETE FROM `Albums` WHERE album_id=".$_GET['albumid']."") or die($mysqli->error);

}
header('Location: myprofile.php')?>
