<?php
 include('connection.php');
    session_start();
  if(!isset($_SESSION['UID']))
  {
    $_SESSION['Login'] = "No";
    $_SESSION['UID'] = "0";
  }
  $auser = $mysqli->query("SELECT user_id FROM Albums Where album_id=".$_GET['albumid']."");
  $auser->data_seek(0);
  $aus = $auser->fetch_assoc();
  $auid = $aus['user_id'];
  $albumq = $mysqli->query("SELECT p.photo_id, p.caption, p.data, a.user_id FROM Albums a, Photos p WHERE p.album_id = a.album_id AND p.album_id = ".$_GET['albumid']."") or die($mysqli->error);

?>
<!DOCTYPE html>
<html>
  <head>
  </head>
  <style>
    html,body{
      background: url("bg_landing.jpg");
      background-size: cover;
      margin:0;
      padding:0;
      color:white;
    }
    .textbox{
      font-size: 1.1em;
      border-style: none;
      background: rgba(255,255,255,0.7);
      padding: 0.1em;
      margin: 0.5em;
      width: 300px;
      border-radius: 0.2em;
}
    }
  </style>
  <body>
    <div id="header" style="color:white;height:6em;background:rgba(0,0,0,0.7);">
      <span style="display:inline-block;font-size:4em;">PhotoSpace</span>
      <span style="display:inline-block;">
        <form action="search.php" id="searchbox" method="get">
          <input type="search" class="textbox" name="query" required placeholder="Search...">
          <select form="searchbox" class="textbox" name="type">
            <option value="P">People</option>
            <option value="T">Tags</option>
          </select>
        </form>
      </span>
      <span style="display:inline-block; color:white; font-size:1em;">
        <?php
          if($_SESSION['Login'] == 'Yes')
            echo "<a href='myprofile.php'>Profile</a>&nbsp;<a href='logout.php'>Logout</a>";
          else if($_SESSION['Login'] == 'No')
            echo "<a href='landing.html'>Login</a>";
        ?><a href='home.php'>Home</a>&nbsp;
      </span>
    </div>
    <div id="body" style="color:black;background:rgba(255,255,255,0.8);">
      <?php

        echo "<h2 style='display:inline-block;'>".$_GET['albumname'].":&nbsp;&nbsp;</h2>";
        if($auid == $_SESSION['UID']) echo "<a href='upload.php?albumid=".$_GET['albumid']."'>(UPLOAD)</a>";
        for($i = 0; $i<$albumq->num_rows;$i=$i+1)
        {
          $albumq->data_seek($i);
          $r = $albumq->fetch_assoc();
          //var_dump($r);
          echo "&nbsp;<a href='viewphoto.php?photoid=".$r['photo_id']."'><img src='".$r['data']."' title='".$r['caption']."' height='100'></a>&nbsp;|";
        }
      ?>
    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
       <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>
</html>
