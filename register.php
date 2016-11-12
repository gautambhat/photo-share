<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>CS660 - Gautam Bhat - U02 24 6123</title>
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
      <span style="font-size:4em;">PhotoSpace</span>
      <a href='home.php'>Home</a>&nbsp;
    </div>
    <div id="body" style="background:rgba(0,0,0,0.5);">

      <form id="regform" action="complete_registration.php" method="POST"></td>
        <table style="padding:1em;">
          <th><h1>Register</h1></th>
          <tr><td>First Name: </td><td><input class="textbox" type="text" name="firstname" required></td></tr>
          <tr><td>Last Name: </td><td><input class="textbox" type="text" name="lastname" required></td></tr>
          <tr><td>Email: </td><td><input class="textbox" type="text" name="email" required></td></tr>
          <tr><td>Password: </td><td><input class="textbox" type="password" name="passwrd" required></td></tr>
          <tr><td>Date of Birth: </td><td><input class="textbox" type="date" name="dob" required></td></tr>
          <tr><td>Hometown: </td><td><input class="textbox" type="text" name="hometown"></td></tr>
          <tr><td>Gender: </td><td>M<input name="gender" type="radio" value="M">&nbsp;F<input name="gender" type="radio" value="F">&nbsp;Tg<input name="gender" type="radio" value="Tg"></td></tr>
          <tr><td colspan="2"><input type="submit" value="GO" style="float:right;font-size: 1.1em;padding: 0.2em;border-style: none;background: rgb(0, 167, 59);border-radius: 0.2em;color: white;"></td></tr>
      </table>
      </form>
      <br><br>
    </div>
    <div id="footer" style="width:100%;color:white;min-height:5em;background:rgba(0,0,0,0.7)">
       <span>CS660 - PA1 - Divyam Hansaria (U 04478133)</span>
    </div>
  </body>  
</html>
