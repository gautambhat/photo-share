<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <form action="complete_upload.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="albumid" value="<?php echo $_GET['albumid']; ?>">
    <input type="file" name="photo" required>
    <input type="text" name="caption" placeholder="caption">
    <input type="submit" value="upload">
  </form>
</html>
