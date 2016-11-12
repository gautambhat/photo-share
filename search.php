<?php
 include('connection.php');

  if(!(isset($_GET['query']) && isset($_GET['type'])))
    header('Location: home.php');

  $searchterm = $_GET['query'];
  $type = $_GET['type'];

  switch($type)
  {
    case 'P': header('Location: psearch.php?query='.$searchterm.'');
      break;
    case 'T': header('Location: tsearch.php?query='.$searchterm.'');
      break;
  }
?>
