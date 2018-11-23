<?php
/** 
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * @version 1.0.0
 * Weekopdracht 3 verwijder user selectie pagina
*/

session_start();

// Kijk of de gebruiker al ingelogd is en Admin is?
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['role']=='User') {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Verwijder user</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet">
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/style.css" type="text/css" rel="stylesheet"> 
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h1>Bas Blog</h1>
                            <h2 class="pull-left">Selecteer users om te verwijderen</h2>
                            <a href="../index.php" class="btn btn-primary pull-right blogbutton">Blog Administratie</a>
                        </div>
                        <?php
                            // Include config file
                            require_once "../config.php";
                            // Query proberen uit te voeren
                            $sql = "SELECT * FROM users";
                            if ($result = $mysqli->query($sql)) {
                                if ($result->num_rows > 0) {
                                    ?>

                                    <!-- Berichten tabel beginnend met de koppen van de kolommen -->
                                    <form action="verwijderuser.php" method="POST">
                                        <table class='table table-borderer table-striped'>
                                            <thead>
                                                <tr>
                                                    <th>verwijderen</th>;
                                                    <th>id</th>;
                                                    <th>username</th>;
                                                    <th>datum van registratie</th>;
                                                </tr>
                                            </thead>
                                            <!-- hier komen de details van de berichten-->
                                            <tbody>
                                            <?php 
                                            while($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><input type="checkbox" name="select<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>"></td>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                            </tbody>";
                                        </table>
                                        <input class="btn btn-danger" type="submit" value="Verwijder"/>
                                    </form>
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
