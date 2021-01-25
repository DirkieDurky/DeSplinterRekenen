<?php
session_start();
    $_SESSION['conn'] = new mysqli("localhost", "root", "", "desplinterrekenen");

/*
Get from database
$stmt = mysqli_stmt_init($_SESSION['conn']);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE id=?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['loggedId']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$_SESSION['row'] = mysqli_fetch_assoc($result);

Insert in database
$stmt = mysqli_stmt_init($_SESSION['conn']);
mysqli_stmt_prepare($stmt, "INSERT INTO accounts (firstName, lastName, email, password, teacher, perms) VALUES (?,?,?,?,?,0);");
$pass = password_hash($_GET['pass'],PASSWORD_DEFAULT);
mysqli_stmt_bind_param($stmt, "ssssi", $_GET['firstname'], $_GET['lastname'], $_GET['email'], $pass, $_GET['teacher']);
mysqli_stmt_execute($stmt);
*/