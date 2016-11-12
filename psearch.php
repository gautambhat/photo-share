<?php
session_start();
  include('connection.php');
  
  if(!isset($_SESSION['UID']))
  {
    $_SESSION['Login'] = "No";
    $_SESSION['UID'] = "0";
  }

  $sq = $mysqli->query("SELECT user_id, first_name, last_name FROM Users WHERE first_name LIKE '%".$_GET['query']."%' or last_name LIKE '%".$_GET['query']."%'") or die($mysqli->error);
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
    <div id="body" style="color:black;background:rgba(255,255,255,0.8);">
      <?php
      echo '<h2>"'.$_GET['query'].'" - Search Results:</h2>';
      for($i = 0; $i < $sq->num_rows;$i=$i+1)
      {
        $sq->data_seek($i);
        $s = $sq->fetch_assoc();
        echo '<div style="padding:0.5em;font-size:2em;"><a href="viewprofile.php?userid='.$s['user_id'].'">'.$s['first_name'].' '.$s['last_name'].'</a></div>';
      }
      ?>
    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
       <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>
</html>
