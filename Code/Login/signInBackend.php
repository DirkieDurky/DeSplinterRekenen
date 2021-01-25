<?php
session_start();
$_SESSION['appMan'] = 0;
$_SESSION['error'] = "";
$_SESSION['errorLength'] = 0;

$_SESSION['signInPass'] = $_GET['pass'];
$_SESSION['signInEmail'] = $_GET['email'];

$conn = new mysqli("localhost", "root", "", "desplinterrekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$_SESSION['loggedID'] = $row['id'];

if ($_GET['email'] == "") {
        $_SESSION['error'] .= "Geen email ingevoerd.<br>";
        unset($_SESSION['signInEmail']);
    } elseif ($row['email'] == "") {
        $_SESSION['error'] .= "Er bestaat geen account dat deze email gebruikt.<br>";
        unset($_SESSION['signInEmail']);
    }
    if ($_GET['pass'] == "") {
        $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
        unset($_SESSION['signInPass']);
    } elseif (!password_verify($_GET['pass'],$row['password']) && $row != "") {
        $_SESSION['error'] .= "Uw wachtwoord is onjuist.<br>";
        unset($_SESSION['signInPass']);
    }

    if ($_SESSION['error'] != "") {
        $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");
        $_SESSION['extendHeight'] = 440 + ($_SESSION['errorLength'] * 24);
        echo $_SESSION['error'];
        header("Location: signIn.php");
        exit();
    } else {
        if ($_GET['rememberMe'] == TRUE){
            setcookie("loginEmail", $_GET['email'], time() + 2592000, "/");
        }
        if ($row['teacher'] == 0) {
            header("Location: ../Student/studentSite.php?selected=1");
        } else {
            $_SESSION['perms'] = $row['perms'];
            header("Location: ../teacher/teacherSite.php?selected=1");
        }
    }