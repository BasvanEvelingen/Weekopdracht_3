<!--
/**
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * Weekopdracht 3 maak een blog
 * Version 2.0
 * View met sorteren op datum of auteur.
 * De zogenaamde bloglezer.
 * DB name = basblogweek3 Table = berichten
 * Veldnamen BerichtID|BerichtTitel|BerichtOmschrijving|BerichtInhoud|Auteur|BerichtDatum
 */
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bas Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
    </head>

    <body>
        <div class="wrapper">
            <img class="blogpicture" src="images/BasBlog.png" />
        </div>
        <div class='wrapper'>;
                        <div class='row'>;
                            <div class='col-lg-8'>;
    <?php
        // Include config file
        require_once "config.php";

        $titel = $omschrijving = $inhoud =  $auteur = $datum = "";
        // Query proberen uit te voeren
        $sql = "SELECT berichten.BerichtTitel, berichten.BerichtOmschrijving, berichten.BerichtInhoud, users.username, 
        berichten.BerichtDatum FROM berichten INNER JOIN users ON berichten.AuteurID=users.id ORDER BY berichten.BerichtDatum DESC";
        if ($result = $mysqli->query($sql)) {
            if ($result->num_rows > 0) { 
                while($row = mysqli_fetch_array($result)) {
                    $titel = $row['BerichtTitel']; 
                    $omschrijving = $row['BerichtOmschrijving'];
                    $inhoud = $row['BerichtInhoud'];
                    $auteur = $row['username'];
                    $datum =  $row['BerichtDatum'];
                    ?>
                            <hr>
                            <h1 class='mt-4'><?php echo $titel ?></h1>
                            <p class='lead'>Door: <?php echo $auteur ?></p>
                            <hr>
                            <p>Posted on: <?php echo $datum ?></p>;
                            <hr>
                            <h3><?php echo $omschrijving ?></h3>";
                            <hr>
                            <p class='lead'><?php echo $inhoud ?></p";
                            <hr>
                    <?php
                }
            }
        }
        ?>
                            </div>
                        </div>
        </div>
    </body>
</html>
