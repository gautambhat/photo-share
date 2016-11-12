<?php
session_start();
include('connection.php');
if(isset($_SESSION['Login']))
  if($_SESSION['UID'] > 0)
    $mysqli->query("INSERT INTO `Albums` (`name`, `date_of_creation`, `user_id`) VALUES ('".$_POST['albumname']."', NOW(), ".$_SESSION['UID'].")") or die($mysqli->error);
header('Location: myprofile.php')?>
