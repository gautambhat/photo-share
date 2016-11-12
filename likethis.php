<?php
session_start();
include('connection.php');
$userid = $mysqli->query("SELECT user_id FROM Albums a, Photos p Where a.album_id = p.album_id and p.photo_id=".$_GET['photoid']."") or die($mysqli->error);
$userid->data_seek(0);
$u = $userid->fetch_assoc();

if($u['user_id'] == $_SESSION['UID'])
  header('Location: viewphoto.php?photoid='.$_GET['photoid']);
else if($_SESSION['UID'] > 0)
  $mysqli->query("INSERT INTO Likes Values (".$_SESSION['UID'].", ".$_GET['photoid'].")");
  header('Location: viewphoto.php?photoid='.$_GET['photoid']);
?>
