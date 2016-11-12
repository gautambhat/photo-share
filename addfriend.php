<?php
include('connection.php');
session_start();

$fid = $_GET['fid'];
$uid = $_SESSION['UID'];

$mysqli->query("INSERT INTO Friends Values(".$uid.",".$fid.")") or die($mysqli->error);

header('Location: viewprofile.php?userid='.$fid);
