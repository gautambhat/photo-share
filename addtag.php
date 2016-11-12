<?php
include('connection.php');
$pid = $_POST['photoid'];
$parts = $_POST['tagname'];

$tag = preg_split('/\s+/', $parts);

foreach ( $tag as $tagNameTemp) {
	
	$tagName = strtolower($tagNameTemp);
	
	$res = $mysqli->query("SELECT tagname from Tags where tagname='".$tagName."'")or die($mysqli->error);
	$checkTagged = $mysqli->query("SELECT tagname from Tagged where photo_id= ".$pid." AND tagname = '".$tagName."'");
	
	if($res->num_rows == 0)
	{
		$mysqli->query("INSERT INTO Tags VALUES('".$tagName."')")or die($mysqli->error);
	}
	
	if($checkTagged->num_rows == 0) {
		$mysqli->query("INSERT INTO Tagged VALUES(".$pid.", '".$tagName."')")or die($mysqli->error);
	}
}

header('Location: viewphoto.php?photoid='.$pid.'');
?>
