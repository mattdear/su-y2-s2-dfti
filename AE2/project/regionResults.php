<?php
session_start();
include("functions.php");
include("poiDAO.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>POI - Region Results</title>
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
        <h2>Region Results</h2>
    </header>
    <?php
    try {
        $conn = databaseConnection();
        $region = $_GET["region"];
        if (preg_match("/^[a-zA-Z ]{2,100}$/", $region)) {
            $poiDAO = new poiDAO($conn, "pointsofinterest");
            $pois = $poiDAO->findByRegion($region);
            if ($pois == null) {
                echo "Your search returned no results please go back and try again.";
            } else {
                echo "<p>Below are the points of interest in $region.</p>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Type</th>";
                echo "<th>Region</th>";
                echo "<th>Country</th>";
                echo "<th>Recommended</th>";
                echo "<th>Added By</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                foreach ($pois as $value) {
                    echo "<tr>";
                    echo "<td>" . $value->getName() . "</td>";
                    echo "<td>" . $value->getDescription() . "</td>";
                    echo "<td>" . $value->getType() . "</td>";
                    echo "<td>" . $value->getRegion() . "</td>";
                    echo "<td>" . $value->getCountry() . "</td>";
                    echo "<td>" . $value->getRecommended() . "</td>";
                    echo "<td>" . $value->getUsername() . "</td>";
                    echo "<td><form method='post' action='addRecommendation.php'><input type='hidden' name='poiId' value=" . $value->getId() . "><input type='hidden' name='region' value='$region'><input type='submit' value='Recommend'></form>";
                    echo "<a href='reviewResults.php?poiId=" . $value->getId() . "'><button>See Reviews</button></a>";
                    echo "<a href='addReviewForm.php?poiId=" . $value->getId() . "'><button>Add Review</button></a></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "No region found please go back and try again.";
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
