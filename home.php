<?php
  include('connection.php');
  session_start();
  if(!isset($_SESSION['UID']))
  {
    $_SESSION['Login'] = "No";
    $_SESSION['UID'] = "0";
  }
  $query1 = "SELECT tagname, count(tagname) from Tagged GROUP BY tagname ORDER BY tagname DESC";
  $tags = $mysqli->query($query1) or die($mysqli->error);
  $query2 = "SELECT (Z1.countz1 + Z2.countz2) as RANK, Z1.u1, Z1.first_name, Z1.last_name
FROM(SELECT u.user_id u1, u.first_name,u.last_name,X.owner_id, count(X.owner_id) as countz1 FROM Users u LEFT JOIN Comments X ON u.user_id = X.owner_id GROUP BY u.user_id) Z1, (SELECT u.user_id u2, X.user_id, u.first_name, u.last_name, count(X.user_id) as countz2 FROM Users u LEFT JOIN (SELECT a.user_id, a.name from photos p JOIN Albums a ON a.album_id = p.album_id) X ON u.user_id = X.user_id GROUP BY u.user_id) Z2
WHERE Z2.u2 = z1.u1 AND (Z1.countz1 + Z2.countz2) > 0
ORDER BY RANK DESC
";

  $active = $mysqli->query($query2) or die($mysql->error);

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
    <div id="body" style="padding:1em;color:black;background:rgba(255,255,255,0.8);">
      <?php
      if($_SESSION['Login'] == 'Yes')
      {
        echo "<div style='font-size=2em;'>You may like...</div>";
        $gettags = "SELECT t.tagname FROM Tagged t1, Photos p1, Albums a1 where t1.photo_id = p1.photo_id AND a1.album_id=p1.album_id AND a1.user_id =".$_SESSION['UID']." GROUP BY t.tagname ORDER BY t.tagname DESC";
        $suggest = $mysqli->query("SELECT count(p.photo_id) AS cnt, p.data, p.photo_id FROM Photos p, Tagged t, Albums a WHERE t.photo_id = p.photo_id AND a.album_id = p.album_id AND a.user_id <> ".$_SESSION['UID']." AND t.tagname IN(".$gettags.") AND NOT EXISTS (SELECT * FROM LIKES WHERE user_id=".$_SESSION['UID']." AND photo_id=p.photo_id)GROUP BY p.photo_id ORDER BY cnt DESC")or die($mysqli->error);

        for($i=0;$i<$suggest->num_rows;$i=$i+1)
        {
          $suggest->data_seek($i);
          $g = $suggest->fetch_assoc();
          echo "<div style='display:inline-block;margin:1em;'><a href='viewphoto.php?photoid=".$g['photo_id']."'><img src='".$g['data']."' height='200'></a></div>";
        }

      }
      echo "<br><hr><br>";
      echo "<div style='font-size:2em;'>Popular Tags :</div>";
      for($i = 0; $i<$tags->num_rows;$i=$i+1)
      {
        $tags->data_seek($i);
        $t= $tags->fetch_assoc();
        echo '<a href="tsearch.php?query='.$t['tagname'].'"><span style="background:purple;color:white;font-size:1.2em;display:inline-block;padding:0.1em;">'.$t['tagname'].'</span></a>&nbsp;';
      }
      echo "<br><hr><br>";
      echo "<div style='font-size:2em;'>Active Users :</div>";
      for($i = 0; $i<$active->num_rows;$i=$i+1)
      {
        $active->data_seek($i);
        $t= $active->fetch_assoc();
        //var_dump($t['u1']);
        echo '<div style="padding:0.5em;font-size:2em;"><a href="viewprofile.php?userid='.$t['u1'].'">'.$t['first_name'].' '.$t['last_name'].'</a></div>';
      }
      die();
      echo "<br><hr><br>";

      ?>
    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
      <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>
</html>
