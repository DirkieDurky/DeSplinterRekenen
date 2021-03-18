<?php
require_once "DB_Connection.php";
session_start();

if (!isset($_GET['answer'])) {
    $_SESSION['error'] = "Je hebt geen antwoord ingevuld";
    header("Location: assignment.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

$sth1 = $pdo -> prepare("SELECT id FROM `questions` WHERE assignmentID = ?");
$sth1 -> execute([$_SESSION['activeAssign']]);
$row = $sth1 -> fetch();

if (isset($_SESSION['editing'])) {
    $question = $_SESSION['activeQuestion']+1;
    if ($sth1 -> rowCount() == $_SESSION['activeQuestion']) {
        $question = $_SESSION['activeQuestion'];
    }
    header("Location: Teacher/AssignmentEditor/assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $question);
    exit();
}

$sth2 = $pdo -> prepare("DELETE FROM `answers` WHERE studentID = ? AND assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['loggedID'],$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$sth3 = $pdo -> prepare("INSERT INTO `answers` (studentID, answer, assignmentID, questionOrder) VALUES (?,?,?,?)");
$sth3 -> execute([$_SESSION['loggedID'], $_GET['answer'], $_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

header("Location: assignment.php?assign=" . $_SESSION['activeAssign'] . "&question=" . ($_SESSION['activeQuestion'] + 1));
exit();