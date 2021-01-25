<?php

$stmt = mysqli_stmt_init($_SESSION['conn']);
mysqli_stmt_prepare($stmt, "INSERT INTO accounts (firstName, lastName, email, password, teacher, perms) VALUES (?,?,?,?,?,0);");
$pass = password_hash($_GET['pass'],PASSWORD_DEFAULT);
mysqli_stmt_bind_param($stmt, "ssssi", $_GET['firstname'], $_GET['lastname'], $_GET['email'], $pass, $_GET['teacher']);
mysqli_stmt_execute($stmt);