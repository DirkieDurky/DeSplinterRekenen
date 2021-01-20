<?php
include "db_connection.php";
if ($_GET['pass'] == $_GET['repass']){
    $Voornaam = $_GET['firstname'];
    $Achternaam = $_GET['lastname'];
    $Email = $_GET['email'];
    $Wachtwoord = $_GET['pass'];
    mysqli_query(OpenCon(),"INSERT INTO accounts (Voornaam, Achternaam, Email, Wachtwoord, Type) 
    VALUES ('$Voornaam', '$Achternaam', '$Email', '$Wachtwoord',0)");
} else {
    header("Location: createaccount.html");
}


/*header("Location: lerarensite.html");*/