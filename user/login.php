<?php
/**
 * @author Bas van Evelingen <BasvanEvelingen@me.com>
 * Weekopdracht 3 login pagina, extra role wordt gezet (user of admin)
 */
// sessie starten
session_start();
 
// Kijken of gebruiker al ingelogd is.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) 
{
    header("location: welkom.php");
    exit;
}
 
// Include config file
require_once "../config.php";
 
// Variabelen initialiseren
$username = $password = $userrole = "";
$username_err = $password_err = "";
 
// Data van formulier verwerken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Gebruikersnaam niet leeg
    if (empty(trim($_POST["username"]))) {
        $username_err = "Vul uw gebruikersnaam in.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Wachtwoord leeg?
    if (empty(trim($_POST["password"]))) {
        $password_err = "Vul uw wachtwoord in.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    //  Wachtwoord controleren
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password,$userrole);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;  
                            $_SESSION["role"] = $userrole;                        
                            
                            // Gebruiker naar de welkompagina loodsen
                            header("location: welkom.php");
                        } else{
                            // Wachtwoord fout
                            $password_err = "Het ingegeven wachtwoord is niet juist.";
                        }
                    }
                } else{
                    // Gebruikersnaam bestaat niet
                    $username_err = "Geen gebruiker gevonden met die naam.";
                }
            } else{
                echo "Er ging iets fout, probeer het later nog eens.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../fonts/font.css" type="text/css" rel="stylesheet">
    <link href="../css/style.css" type="text/css" rel="stylesheet"> 
</head>
<body>
    <div class="wrapper">
        <img class="blogpicture" src="../images/BlogLogin.png" />
        <h1>Login</h1>
        <p>Vul uw gegevens in.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Bent u nog geen gebruiker? <a href="register.php">Schrijf u nu in.</a></p>
        </form>
    </div>    
</body>
</html>
