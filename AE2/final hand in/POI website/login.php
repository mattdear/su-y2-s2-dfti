<?php
session_start();
include("functions.php");
include("usersDAO.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>POI - Login</title>
</head>
<body>
<div id="main_content">
    <header>
        <?php
        title($_SESSION["gatekeeper"], $_SESSION["isadmin"], $byDefault = 0);
        if (isset ($_SESSION["gatekeeper"])) {
            echo "<p>Logged In User, " . $_SESSION["gatekeeper"] . "</p><br>";
        }
        backbutton();
        ?>
        <h2>Login</h2>
    </header>
    <?php
    try {
        $conn = databaseConnection();
        $un = $_POST["username"];
        $pw = $_POST["password"];
        if (preg_match("/^[a-z]{2,30}$/", $un) && preg_match("/^[a-zA-Z0-9]{2,30}$/", $pw)) {
            $usersDAO = new usersDAO($conn, "poi_users");
            $usersDTO = $usersDAO->verifyLogin($un, $pw);
            if ($usersDTO != null) {
                $_SESSION["gatekeeper"] = $un;
                $_SESSION["isadmin"] = (int)$usersDTO->getIsadmin();
                header("location: index.php");
            } else {
                echo "Username or password not found please go back and try again.";
            }
        } else {
            echo "No username or password entered please go back and try again.";
        }
    } catch (PDOException $e) {
        echo "Error: $e";
    }
    ?>
</div>
<!--</div id="main_content"-->
<?php footer() ?>
</body>
</html>
