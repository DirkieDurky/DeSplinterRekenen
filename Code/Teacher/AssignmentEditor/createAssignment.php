<?php
require_once "../../DB_Connection.php";
session_start();

if (strlen($_GET['assignmentName'])==0) {
    $_SESSION['error'] =  "De naam van je opdracht moet minstens 1 karakter bevatten.";
    header("Location: ../teacherSite.php?selected=2");
    exit();
}

if (strlen($_GET['assignmentName'])>35) {
    $_SESSION['error'] =  "De naam van je opdracht kan maximaal 35 karakters bevatten.";
    header("Location: ../teacherSite.php?selected=2");
    exit();
}

$one = $_GET['assignmentName'];
$two = $_SESSION['loggedID'];
echo $one;
echo $two;

$sth = $pdo -> prepare("INSERT INTO `assignments` (`name`,`creatorID`,`public`) VALUES (?,?,?)");
$sth -> execute([$one,$two,0]);
unset($_GET['createAssignButton']);
header("Location: ../teacherSite.php?selected=2");
exit();