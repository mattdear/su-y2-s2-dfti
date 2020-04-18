<?php
session_start();
include("functions.php");
include("reviewsDAO.php");
include("poiDAO.php");
if (!isset ($_SESSION["isadmin"]) && $_SESSION["isadmin"] != 1) {
    header("Location: loginForm.php");
} else {
    ?>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>POI - Review Approval</title>
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
            <h2>Review Approval</h2>
        </header>
        <?php
        try {
            $conn = databaseConnection();
            $reviewsDAO = new reviewsDAO($conn, "poi_reviews");
            $reviews = $reviewsDAO->findByUnapproved();
            $poiDAO = new poiDAO($conn, "pointsofinterest");
            if ($reviews != null) {
              echo "<p>Below are all reviews pending approval.</p>";
              echo "<table>";
              echo "<tr>";
              echo "<th>POI</th>";
              echo "<th>Review</th>";
              echo "<th>Approve?</th>";
              echo "</tr>";
              foreach ($reviews as $value) {
                  $poiId = $value->getId();
                  $returnedPOI = poiDAO->findById($poiId);
                  echo "<tr>";
                  echo "<td>" . $returnedPOI->getId() . "</td>";
                  echo "<td>" . $value->getReview() . "</td>";
                  echo "<td><form method='post' action='approveReview.php'><input type='hidden' name='id' value=" . $value->getId() . "><input type='submit' value='Approve'></form><form method='post' action='deleteReview.php'><input type='hidden' name='id' value=" . $value->getId() . "><input type='submit' value='Delete'></form></td>";
                  echo "</tr>";
              }
              echo "</table>";
            } else {
                echo "Something went wrong please go back and try again.";
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
    <?php
}
?>
