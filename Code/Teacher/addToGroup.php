<?php
require_once ("../DB_Connection.php");
session_start();

if (!isset($_GET['groups'])) {
    $_SESSION['error'] = "Je hebt geen groep geselecteerd om leerlingen aan toe te voegen.";
    header("Location: teacherSite.php?selected=1");
    exit();
}

$sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0");
$sth -> execute();
$row = $sth -> fetch();

$sth2 = $pdo -> prepare("SELECT * FROM `groups` WHERE name = ?");
$sth2 -> execute([$_GET['groups']]);
$row2 = $sth2 -> fetch();

do {
    if (isset($_GET['select' . $row['id']])) {
        $sth3 = $pdo -> prepare("UPDATE `accounts` SET groupID = ? WHERE id = ?");
        $sth3 -> execute([$row2['id'], $row['id']]);
        echo "select" . $row['id'] . " was checked<br>";
    } else {
        echo "select" . $row['id'] . " was not checked<br>";
    }
} while ($row = $sth -> fetch());
header("Location: teacherSite.php?selected=1");
exit();