<?php
/** 
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * @version 2.0.1
 * Weekopdracht 3 update de blog
 * CRUD opzet Hoofdpagina, nu verschil in rollen, Admin en User.
 * De hele tabel echo'en er uitgehaald
 * Berichten uit blog en userinterface weergeven
 * DB name = basblog Table = berichten
 * Veldnamen BerichtID|BerichtTitel|BerichtOmschrijving|BerichtInhoud|Auteur|BerichtDatum
*/

session_start();

// Kijk of de gebruiker al ingelogd is?
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: user/login.php");
    exit();
} else {
    // verschillende query's voor de twee rollen
    if ($_SESSION['role']==="Admin") {
        $deletedisplay="initial";
        $sql = "SELECT berichten.berichtID,berichten.BerichtTitel, berichten.BerichtOmschrijving, berichten.BerichtInhoud , 
        users.username, berichten.BerichtDatum FROM berichten INNER JOIN users ON berichten.BerichtID=users.id 
        ORDER BY berichten.BerichtDatum DESC";
    } elseif ($_SESSION['role']==="User") {
        $debuginfo = "user?";
        $deletedisplay="none";
        $id = $_SESSION['id'];
        $sql = "SELECT berichten.berichtID, berichten.BerichtTitel, berichten.BerichtOmschrijving, berichten.BerichtInhoud ,
        users.username, berichten.BerichtDatum FROM berichten INNER JOIN users ON berichten.AuteurID=users.id 
        WHERE berichten.AuteurID=$id ORDER BY berichten.BerichtDatum DESC";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bas Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet">
        <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet"> 
        <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h1>Bas Blog</h1>
                            <h6><?php echo $debuginfo; ?></h6>
                            <h2 class="pull-left">Berichten van <?php echo  $_SESSION["username"]; ?></h2>
                            <a href="user/welkom.php" class="btn btn-warning pull-right blogbutton">Hoofdmenu</a>
                            <a href="nieuwbericht.php" class="btn btn-primary pull-right blogbutton">Nieuw Bericht</a>
                            <a style="display:<?php echo $deletedisplay; ?>" href="user/verwijderuserindex.php" class="btn btn-danger pull-right blogbutton">Verwijder User(s)</a>
                        </div>
                        <?php
                            // Include config file
                            require_once "config.php";
                            // Query proberen uit te voeren
                            //$sql = "SELECT * FROM berichten ORDER BY BerichtDatum DESC";
                            if ($result = $mysqli->query($sql)) {
                                if ($result->num_rows > 0) {
                                    ?>
                                    <!-- Berichten tabel beginnend met de koppen van de kolommen -->
                                   <table class='table table-borderer table-striped'>
                                        <thead>
                                            <tr>
                                                <th>titel</th>
                                                <th>omschrijving</th>
                                                <th>inhoud</th>
                                                <th>auteur</th>
                                                <th>datum</th>
                                                <th>acties</th>
                                            </tr>
                                        </thead>
                                        <!-- hier komen de details van de berichten-->
                                        <tbody>
                                        <?php 
                                        while($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['BerichtTitel']; ?></td>
                                                <td><?php echo $row['BerichtOmschrijving']; ?></td>
                                                <td><?php echo $row['BerichtInhoud']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['BerichtDatum']; ?></td>
                                                <td>
                                                    <a href='leesbericht.php?id="<?php echo $row['BerichtID']; ?>"' title='Lees Bericht' data-toggle='tooltip'><i class='far fa-eye fa-2x'></i></a>
                                                    <a href='updatebericht.php?id="<?php echo $row['BerichtID']; ?>"' title='Bewerk Bericht' data-toggle='tooltip'><i class='far fa-edit fa-2x'></i></a>
                                                    <a href='verwijderbericht.php?id="<?php echo $row['BerichtID']; ?>"' title='Verwijder Bericht' data-toggle='tooltip'><i class='far fa-trash-alt fa-2x'></i></a>
                                                </td>
                                            </tr>
                                        <?php 
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    // result vrijgeven
                                    $result->free();
                                } else {
                                    echo "Geen berichten gevonden.";
                                }
                            } else {
                                echo "ERROR: Kon volgende query niet uitvoeren: $sql. " . mysqli_error($link);
                            }
                            // sluit connectie
                            $mysqli->close();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
