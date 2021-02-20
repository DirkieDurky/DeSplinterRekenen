<?php
session_start();
require_once ("../DB_Connection.php");

$sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=1 AND id!=?");
$sth -> execute([$_SESSION['loggedID']]);
$row = $sth -> fetch();

for ($j=0; $j<$_SESSION['i']; $j++, $row = $sth -> fetch()){
    $sth2 = $pdo -> prepare("UPDATE `accounts` SET perms = ? WHERE id = ?");
    $sth2 -> execute([$_GET['perms' . $j], $row['id']]);
    echo "Set the perms for user with id " . $row['id'] . " to " . $_GET['perms' . $j] . "<br>";
}
$_SESSION['notification'] = "Veranderingen zijn opgeslagen!";
header("Location: teacherSite.php?selected=0");