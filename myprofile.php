<?php
  include('connection.php');
  session_start();
  if($_SESSION['Login'] != 'Yes')
  {
    header('Location: home.php');
  }

  $res = $mysqli->query("SELECT * FROM Users WHERE user_id = ".$_SESSION['UID']."") or die($mysql->error);
  $res->data_seek(0);
  $row = $res->fetch_assoc();

  $albumq = $mysqli->query("SELECT a.name, a.album_id FROM Albums a, Users u WHERE a.user_id = u.user_id AND a.user_id=".$_SESSION['UID']."") or die($mysqli->error);
  $friendq = $mysqli->query("SELECT u.first_name,u.user_id FROM Friends f, Users u WHERE f.user_fid = u.user_id AND f.user_id=".$_SESSION['UID']."") or die($mysqli->error);
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
        ?>
          <a href='home.php'>Home</a>&nbsp;
      </span>
    </div>
    <div id="body" style="color:black;background:rgba(255,255,255, 0.8);">
      <br>
      <?php

        echo "<h2>".$row['first_name']."&nbsp;".$row['last_name']."<h2 style='display:inline-block;'><br><br>ALBUMS:&nbsp;&nbsp;</h2>";
        for($i = 0; $i<$albumq->num_rows;$i=$i+1)
        {
          $albumq->data_seek($i);
          $r = $albumq->fetch_assoc();
          //var_dump($r);
          echo "&nbsp;<a href='viewalbum.php?albumid=".$r['album_id']."&albumname=".$r['name']."'>".$r['name']."</a><a href='deletealbum.php?albumid=".$r['album_id']."'>&nbsp;(delete)</a>&nbsp;|";
        }
      ?>
      &nbsp;
      <form style="display:inline-block;" action="createalbum.php" method="POST"><input type="text" name="albumname" required placeholder="Album Name"><input type="submit" value="CREATE"></form>
      <br>
      <?php

        echo "<h2 style='display:inline-block;'><br><br>FRIENDS:&nbsp;&nbsp;</h2>";
        for($i = 0; $i<$friendq->num_rows;$i=$i+1)
        {
          $friendq->data_seek($i);
          $r = $friendq->fetch_assoc();
          //var_dump($r);
          echo "&nbsp;<a href='viewprofile.php?userid=".$r['user_id']."'>".$r['first_name']."</a>&nbsp;|";
        }
      ?>

    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
       <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>
</html>
