<?php
require_once "../../DB_Connection.php";
session_start();

if (!isset($_GET['answer'])) {
    $_SESSION['error'] = "Je hebt geen antwoord ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

$sth2 = $pdo -> prepare("SELECT id FROM `questions` WHERE assignmentID = ?");
$sth2 -> execute([$_SESSION['activeAssign']]);
$row = $sth2 -> fetch();

if (isset($_SESSION['activeAssign'])) {
    $question = $_SESSION['activeQuestion']+1;
    if ($sth2 -> rowCount() == $_SESSION['activeQuestion']) {
        $question = $_SESSION['activeQuestion'];
    }
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $question);
    exit();
}

$sth = $pdo -> prepare("INSERT INTO `answers` (studentID, answer, assignmentID, questionOrder) VALUES (?,?,?,?)");
$sth -> execute([$_SESSION['loggedID'],$_GET['answer'],$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$question = $_SESSION['activeQuestion'];
if ($sth2 -> rowCount() == $_SESSION['activeQuestion']) {
    header("Location: ../../Student/studentSite.php");
}

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']+1);
exit();