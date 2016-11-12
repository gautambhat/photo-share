<?php
include('connection.php');
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $dob = $_POST['dob'];
  $pwd = $_POST['passwrd'];
  $email = $_POST['email'];
  $hometown = isset($_POST['hometown'])?$_POST['hometown']:'';
  $gender= isset($_POST['gender'])?$_POST['gender']:'';

  $emailcheck = $mysqli->query("SELECT email FROM Users WHERE email = '".$email."'");
  if($emailcheck->num_rows == 1){
    echo "User with email ".$email." already exists. Login <a href='landing.html'>here</a>";
    die();
  }
  $mysqli->query("INSERT INTO `Users`(`first_name`, `last_name`, `email`, `date_of_birth`, `pwrd`) VALUES ('".$fname."','".$lname."','".$email."','".$dob."','".$pwd."')") or die($mysqli->error);
  if(isset($_POST['hometown']))
    $mysqli->query("UPDATE users SET hometown = '".$_POST['hometown']."' WHERE email = '".$email."'");

  if(isset($_POST['gender']))
    $mysqli->query("UPDATE users SET gender= '".$_POST['gender']."' WHERE email = '".$email."'");
  header('Location: landing.html');
?>
