<!DOCTYPE html>
<html>
<head>
<title>PointsOfInterest - Login</title>
</head>
<body>
  <?php
  include("functions.php");
  session_start();
  title();
  if (isset ($_SESSION["gatekeeper"]))
  {
    $un = $_SESSION["gatekeeper"];
    echo "<p>Welcome, $un<p>";
  }
  ?>
<p>Login below using your username and password.</p>
<form method="post" action="login.php">
<label for="username">Username:</label>
<input name="username" id="username"/>
<br/>
<label for="password">Password:</label>
<input name="password" id="password" type="password"/>
<br/>
<br/>
<input type="submit" value="Login" />
<br/>
<br/>
</form>
<?php footer()?>
</body>
</html>