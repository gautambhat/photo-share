<?php
 include('connection.php');
$pid = $_POST['photoid'];
$tag = $_POST['tagname'];
$tags = explode(" ", $_POST['tagname']);

$query = "SELECT p.photo_id FROM Photos p, Tagged t WHERE p.photo_id = t.photo_id AND " or die($mysqli->error);
for($i = 0;$i< sizeof($tags);$i=$i+1)
{
  if($i == 0)
    $query = $query . "EXISTS (SELECT * from Tagged where tagname = '".$tags[$i]."' AND photo_id = p.photo_id) ";
  else $query = $query . "AND EXISTS (SELECT * from Tagged where tagname = '".$tags[$i]."' AND photo_id = p.photo_id) ";
}


$query2 = "SELECT count(tagname), tagname FROM Tagged WHERE photo_id IN (".$query.") AND tagname NOT IN (";
for($i = 0;$i< sizeof($tags);$i=$i+1)
{
  if($i == 0)
    $query2 = $query2 . "'".$tags[$i]."'";
  else $query2 = $query2 . ",'".$tags[$i]."'";
}
$query2 = $query2 . ') GROUP BY tagname ORDER BY count(tagname) DESC';
//echo $query2;

$res = $mysqli->query($query2) or die($mysqli->error);
$result = '';
for($i = 0;$i<$res->num_rows;$i=$i+1)
{
  $res->data_seek($i);
  $r = $res->fetch_assoc();
  $result = $result . $r['tagname'] . "%20";
}
echo $result;
header('Location: viewphoto.php?photoid='.$pid.'&suggested='.$result);
?>
