<?php
session_start();
$_SESSION['error'] = "";
$_SESSION['errorlength'] = 0;
if (!preg_match('/^[a-zA-Z]+$/', $_GET['firstname'])){
    $_SESSION['error'] .= "Voornaam is niet geldig.<br>";
}
if (!preg_match('/^[a-zA-Z]+$/', $_GET['lastname'])){
    $_SESSION['error'] .= "Achternaam is niet geldig.<br>";
}
if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] .= "Email is niet geldig.<br>";
}
if ($_GET['pass']==""){
    $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
} else {
    if (!preg_match('@[A-Z]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 hoofdletter bevatten.<br>";
    }
    if (!preg_match('@[a-z]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 kleine letter bevatten.<br>";
    }
    if (!preg_match('@[0-9]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 cijfer bevatten.<br>";
    }
    if (!preg_match('@[^\w]@', $_GET['pass'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 speciaal karakter bevatten.<br>";
    }
    if (strlen($_GET['pass'])<8){
        $_SESSION['error'] .= "Wachtwoord moet minstens 8 karakters bevatten.<br>";
    }
    if ($_GET['pass']!=$_GET['repass']){
        $_SESSION['error'] .= "Wachtwoorden komen niet overeen.<br>";
    }
}

$_SESSION['errorlength'] = substr_count($_SESSION['error'],"<br>");

if ($_SESSION['error']!=""){
    $_SESSION['extendheight'] = 733+($_SESSION['errorlength']*24);
    header("Location: createaccount.php");
    exit();
} else {
    include "db_connection.php";
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $email = $_GET['email'];
    $pass = $_GET['pass'];
    mysqli_query(OpenCon(),"INSERT INTO accounts (Voornaam, Achternaam, Email, Wachtwoord, Type) VALUES ('$firstname', '$lastname', '$email', '$pass',FALSE)");
    header("Location: lerarensite.html");
    exit();
}