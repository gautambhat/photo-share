<?php
   include('connection.php');
  if(!isset($_GET['photoid'])) {
        header('Location: myprofile.php');
  }
  $pid = $_GET['photoid'];

  session_start();
  if(!isset($_SESSION['UID']))
  {
    $_SESSION['Login'] = "No";
    $_SESSION['UID'] = "0";
  }

  $photoq = $mysqli->query("SELECT * FROM Photos Where photo_id = ".$pid."") or die($mysqli->error);
  $tagq = $mysqli->query("SELECT tagname FROM Tagged Where photo_id = ".$pid."") or die($mysqli->error);
  $albumq = $mysqli->query("SELECT * FROM Albums a, Photos p Where a.album_id = p.album_id and p.photo_id=".$pid."") or die($mysqli->error);
  $likeq = $mysqli->query("SELECT u.user_id,u.first_name, u.last_name FROM Likes l, Users u Where l.user_id = u.user_id AND l.photo_id = ".$pid."") or die($mysqli->error);
  $comment = $mysqli->query("SELECT c.comment_id,c.text,c.dateleft,c.owner_id FROM Comments c Where c.photo_id = ".$pid."") or die($mysqli->error);

  $photoq->data_seek(0);
  $p = $photoq->fetch_assoc();
  $p_src = $p['data'];
  $p_caption = $p['caption'];

  $albumq->data_seek(0);
  $a = $albumq->fetch_assoc();
  $a_id = $a['album_id'];
  $a_name = $a['name'];
  $a_uid = $a['user_id'];

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
      <img src="<?php echo $p_src;?>" height="500">
      <p>"<?php echo $p_caption;?>"</p>
      <?php
      for($i = 0; $i< $tagq->num_rows;$i=$i+1)
      {
        $tagq->data_seek($i);
        $t = $tagq->fetch_assoc();
        echo '<a href="tsearch.php?query='.$t['tagname'].'"><span style="background:purple;color:white;font-size:1.2em;display:inline-block;padding:0.1em;">'.$t['tagname'].'</span></a>&nbsp;';
      }

      if($_SESSION['UID'] == $a_uid)
      {
        if(isset($_GET['suggested']))
            echo "<form action='addtag.php' method='post'><input type='hidden' name='photoid' value='".$pid."'><input type='text' name='tagname' value='".$_GET['suggested']."' required placeholder='Add a Tag!'><input type='submit'></form>";
        else echo "<form action='addtag.php' method='post'><input type='hidden' name='photoid' value='".$pid."'><input type='text' name='tagname' required placeholder='Add a Tag!'><input type='submit'></form>";
        echo "<form action='suggesttag.php' method='post'><input type='hidden' name='photoid' value='".$pid."'><input type='text' name='tagname' required placeholder='Suggest Tags!'><input type='submit'></form>";

          echo "<div style='margin:0.2em;''><a href='deletephoto.php?photoid=".$pid."&albumid=".$a_id."'>DELETE PHOTO</a></div>";
      }
      echo "<br><a href='likethis.php?photoid=".$pid."'>LIKE</a><br>Liked By (".$likeq->num_rows."): ";
      for($i = 0; $i< $likeq->num_rows;$i=$i+1)
      {
        $likeq->data_seek($i);
        $t = $likeq->fetch_assoc();
        echo '&nbsp;|&nbsp;'.$t['first_name'].' '.$t['last_name'];
      }
      echo "<br>";
      echo 'Comments:';
      for($i = 0; $i< $comment->num_rows;$i=$i+1)
      {
        $comment->data_seek($i);
        $t = $comment->fetch_assoc();
        $ownername = '';
        if($t['owner_id'] == 0)
          $ownername = $ownername.'Anonymous';
        else {
          $name = $mysqli->query("SELECT first_name, last_name from Users where user_id=".$t['owner_id']."")or die($mysqli->error);
          $name->data_seek(0);
          $n = $name->fetch_assoc();
          $ownername = $ownername.$n['first_name'].' '.$n['last_name'];
        }
        echo '<div>'.$ownername.'&nbsp;|&nbsp;'.$t['dateleft'].': '.$t['text'].'</div>';
      }
      ?>
      <form action="comment.php" method="POST">
        <input type="hidden" name="photoid" value="<?php echo $pid;?>">
        <input type="text" name="comment" required placeholder="Comment...">
        <input type="submit">
      </form>
    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
     <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>
</html>
