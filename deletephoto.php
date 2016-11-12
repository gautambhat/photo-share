<?php
session_start();
include('connection.php');
$pathq = $mysqli->query("SELECT `data` from Photos WHERE photo_id = ".$_GET['photoid']."")or die($mysqli->error);
$pathq->data_seek(0);
$path = $pathq->fetch_assoc();
$p = $path['data'];

$res = $mysqli->query("SELECT user_id from Albums where album_id=".$_GET['albumid']."") or die($mysqli->error);
$res->data_seek(0);
$r = $res->fetch_assoc();
if($r['user_id'] == $_SESSION['UID'])
{
  $mysqli->query("DELETE FROM `Likes` WHERE photo_id=".$_GET['photoid']."") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Comments` WHERE photo_id=".$_GET['photoid']."") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Tagged` WHERE photo_id=".$_GET['photoid']."") or die($mysqli->error);
  $mysqli->query("DELETE FROM `Photos` WHERE photo_id=".$_GET['photoid']."") or die($mysqli->error);
  if(!unlink($p))
 echo "error deleting, please try again! ";
}
$res = $mysqli->query("SELECT name from Albums WHERE album_id=".$_GET['albumid']."");
$res->data_seek(0);
$r = $res->fetch_assoc();
header('Location: viewalbum.php?albumid='.$_GET['albumid'].'&albumname='.$r['name']);
?>
