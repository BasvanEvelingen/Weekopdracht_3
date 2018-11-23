<?php
/**
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * Weekopdracht 3 maak een blog
 * C(R)UD opzet <- Read
 * Berichten uit Database lezen
 * DB name = basblog Table = berichten
 * Veldnamen BerichtID|BerichtTitel|BerichtOmschrijving|BerichtInhoud|AuteurID|BerichtDatum 
 */

// Is er een parameter meegegeven
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config bestand
    require_once "config.php";
    
    // Query voorbereiden object-georiënteerd.
    $sql = "SELECT berichten.BerichtTitel, berichten.BerichtOmschrijving, berichten.BerichtInhoud,
    users.username, berichten.BerichtDatum FROM berichten INNER JOIN users ON berichten.AuteurID=users.id 
    WHERE BerichtID = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = trim($_GET["id"]);
        // query uitvoeren
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                /* resultaat binnenhalen als associatieve array dus geen loop nodig */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                // database velden toekennen aan variabelen voor verwerking in html 
                $id = $row["BerichtID"];
                $titel = $row["BerichtTitel"];
                $auteur = $row["users.username"];
                $omschrijving = $row["BerichtOmschrijving"];
                $inhoud = $row["BerichtInhoud"];
                $datum = $row["BerichtDatum"];
            } else {
                // Geen goede id
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Er ging iets verkeerd, probeer het later nog eens.";
        }
    }
     
    // Sluit statement
    $stmt->close();
    
    // Sluit connectie
    $mysqli->close();
} else{
    // Geen id meegegeven
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bericht Bekijken</title>
    <link href="https://fonts.googleapis.com/css?font=Bitter" rel="stylesheet">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" >
    <link href="css/style.css" type="text/css" rel="stylesheet.css">
</head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h1>Bekijk bericht</h1>
                        </div>
                        <div class="panel-group">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <label>Titel</label>
                                    <p><?php echo "$titel"; ?></p>
                                </div>
                                <div class="panel-body">
                                    <label>Auteur</label>
                                    <p><?php echo "$auteur"; ?></p>
                                </div>
                                <div class="panel-body">
                                    <label>Omschrijving</label>
                                    <p><?php echo "$omschrijving"; ?></p>
                                </div>
                                <div class="panel-body">
                                    <label>Omschrijving</label>
                                    <p><?php echo "$inhoud"; ?></p>
                                </div> 
                                <div class="panel-body">
                                    <label>Datum</label>
                                    <p><?php echo "$datum"; ?></p>
                                </div>
                            </div>
                        </div>
                        <p><a href="index.php" class="btn btn-primary">Terug</a></p>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>
