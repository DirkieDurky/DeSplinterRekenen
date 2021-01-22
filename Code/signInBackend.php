<?php
include_once "db_connection.php";
$_SESSION['error'] = "";
$_SESSION['errorLength'] = 0;

$_SESSION['conn'] = new mysqli("localhost", "root", "","desplinterrekenen");
$stmt = mysqli_stmt_init($_SESSION['conn']);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE Email=?");
if (isset($_COOKIE['userEmail'])){
    mysqli_stmt_bind_param($stmt, "s", $_COOKIE['userEmail']);
} else {
    mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (isset($_COOKIE['userEmail'])){
    if ($row['Password'] == password_hash($_COOKIE['userPass'], PASSWORD_DEFAULT) && $row != ""){
        if ($row['Type'] == 0) {
            header("Location: teacherSite.html");
        } else {
            header("Location: studentSite.html");
        }
    } else {
        setcookie('userEmail',"",time() - 3600);
        setcookie('userPass',"",time() - 3600);
        $_SESSION['error'] = "Deleted cookies!";
        header("Location: signIn.php");
    }
} else {
    if ($_GET['email'] == "") {
        $_SESSION['error'] .= "Geen email ingevoerd.<br>";
        $_SESSION['signInPass'] = $_GET['pass'];
    } elseif ($row == "") {
        $_SESSION['error'] .= "Er bestaat geen account dat deze email gebruikt.<br>";
        $_SESSION['signInPass'] = $_GET['pass'];
    }
    if ($_GET['pass'] == "") {
        $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
        $_SESSION['signInEmail'] = $_GET['email'];
    } elseif (!$row['Password'] == password_hash($_GET['pass'], PASSWORD_DEFAULT) && $row != "") {
        $_SESSION['error'] .= "Uw wachtwoord is onjuist.<br>";
        $_SESSION['signInEmail'] = $_GET['email'];
    }

    if ($_SESSION['error'] != "") {
        $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");
        $_SESSION['extendHeight'] = 440 + ($_SESSION['errorLength'] * 24);
        header("Location: signIn.php");
        exit();
    } else {
        setcookie("userEmail", $_GET['email']);
        setcookie("userPass", password_hash($_GET['pass'],PASSWORD_DEFAULT));
        if ($row['Type'] == 0) {
            header("Location: teacherSite.html");
        } else {
            header("Location: studentSite.html");
        }
    }
}