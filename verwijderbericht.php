<?php
/**
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * Weekopdracht 3 update van de blog
 * CRU(D) opzet <- Delete
 * Bericht in database verwijderen
 * DB name = basblog Table = berichten
 * Veldnamen BerichtID|BerichtTitel|BerichtOmschrijving|BerichtInhoud|Auteur|BerichtDatum 
 */
// Bericht verwijderen na bevestiging
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Include config file
    require_once "config.php";
    
    // statement voorbereiden
    $sql = "DELETE FROM berichten WHERE BerichtID = ?";
    
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variabele aan parameters
        $stmt->bind_param("i", $param_id);
        
        // parameter zetten
        $param_id = trim($_POST["id"]);
        
        // poging wagen statement uit te voeren
        if ($stmt->execute()) {
            // Succes bericht verwijderd terug naar homepage
            header("location: index.php");
            exit();
        } else {
            echo "Er ging iets fout, probeer het later nog eens";
        }
    }
     
    // Sluit statement
    $stmt->close();
    
    // Sluit connectie
    $mysqli->close();
} else {
    // Kijken of er een id parameter is
    if (empty(trim($_GET["id"]))) {
        // Nee?, ga naar error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verwijder bericht</title>
        <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet">
        <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>Verwijder Bericht</h1>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="alert alert-danger fade in">
                                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                                <p>Weet u zeker dat u het bericht wilt verwijderen?</p><br>
                                <p>
                                    <input type="submit" value="Yes" class="btn btn-danger">
                                    <a href="index.php" class="btn btn-default">No</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>
