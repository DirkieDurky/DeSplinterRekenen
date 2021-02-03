<?php
session_start();
$_SESSION['error'] = "";
$_SESSION['errorLength'] = 0;

$_SESSION['creAccFirst'] = $_GET['firstname'];
$_SESSION['creAccLast'] = $_GET['lastname'];
$_SESSION['creAccEmail'] = $_GET['email'];
$_SESSION['creAccPass'] = $_GET['pass'];
$_SESSION['creAccRepass'] = $_GET['repass'];

if ($_GET['firstname'] == ""){
    $_SESSION['error'] .= "Geen Voornaam ingevoerd.<br>";
    unset($_SESSION['creAccFirst']);
} else if (!preg_match('/^[a-zA-Z]+$/', $_GET['firstname'])){
    $_SESSION['error'] .= "Voornaam is niet geldig.<br>";
    unset($_SESSION['creAccFirst']);
}
if ($_GET['lastname'] == ""){
    $_SESSION['error'] .= "Geen Achternaam ingevoerd.<br>";
    unset($_SESSION['creAccLast']);
} else if (!preg_match('/^[a-zA-Z]+$/', $_GET['lastname'])){
    $_SESSION['error'] .= "Achternaam is niet geldig.<br>";
    unset($_SESSION['creAccLast']);
}
if ($_GET['email'] == ""){
    $_SESSION['error'] .= "Geen email ingevoerd.<br>";
    unset($_SESSION['creAccEmail']);
} else if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] .= "Email is niet geldig.<br>";
        unset($_SESSION['creAccEmail']);
    } else {
        //Check if there is an account using entered email
        $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE Email=?");
        mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $_SESSION['row'] = mysqli_fetch_assoc($result);
        if ($_SESSION['row'] != "") {
            $_SESSION['error'] .= "Er bestaat al een ander account dat dit email gebruikt.<br>";
            unset($_SESSION['creAccEmail']);
        }
    }
if ($_GET['pass'] == ""){
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
    unset($_SESSION['creAccPass']);
    unset($_SESSION['creAccRepass']);
}
if (!isset($_GET['teacher'])){
    $_SESSION['error'] .= "Je hebt niet aangegeven of je een leraar of een leerling bent.<br>";
}

$_SESSION['errorLength'] = substr_count($_SESSION['error'],"<br>");

if ($_SESSION['error']!=""){
    $_SESSION['extendHeight'] = 710 + ($_SESSION['errorLength'] * 23);
    header("Location: createAccount.php");
    exit();
} else {
    $pass = password_hash($_GET['pass'],PASSWORD_DEFAULT);
        $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "INSERT INTO `accounts` (`firstName`, `lastName`, `email`, `password`, `teacher`, `perms`, `groupID`) VALUES (?,?,?,?,?,0,1);");
        mysqli_stmt_bind_param($stmt, "ssssi", $_GET['firstname'], $_GET['lastname'], $_GET['email'], $pass, $_GET['teacher']);
        mysqli_stmt_execute($stmt);

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE Email=?");
        mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!isset($row['perms'])) {
            $_SESSION['error'] .= "Er ging aan onze kant iets mis bij het maken van je account, sorry! Probeer het later opnieuw.<br>";
            $_SESSION['extendHeight'] = 750;
            header("Location: createAccount.php");
            exit();
        }

    $_SESSION['loggedID'] = $row['id'];

    if ($_GET['teacher'] == 0) {
        header("Location: ../Student/studentSite.php?selected=1");
    } else {
        header("Location: ../teacher/teacherSite.php?selected=1");
    }
}