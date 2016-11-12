<?php
  include('connection.php');
  $username = $_POST['username'];
  $password = $_POST['passwrd'];

  $authcheck = $mysqli->query("SELECT user_id from Users where email ='".$username."' AND pwrd = '".$password."'") or die($mysqli->error);
  if($authcheck->num_rows <= 0)
  {
    echo "Username and password combination not found. Please try again <a href='landing.html'>here</a>.";
    die();
  }
  else if($authcheck->num_rows == 1)
  {
    $authcheck->data_seek(0);
    $row = $authcheck->fetch_assoc();
    session_start();
    $_SESSION["Login"] = "Yes";
    $_SESSION["UID"] = $row['user_id'];
    header('Location: home.php');
  }

?>
