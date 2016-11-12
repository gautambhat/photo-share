<?php

  session_start();
  $_SESSION['Login'] = 'No';
  $_SESSION['UID'] = 0;
  session_unset();
  session_destroy();

  header('Location: landing.html');
?>
