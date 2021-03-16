<?php
require_once "../../DB_Connection.php";
session_start();

if (!isset($_GET['answer'])) {
    $_SESSION['error'] = "Je hebt geen antwoord ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
    exit();
}

$sth2 = $pdo -> prepare("SELECT id FROM `questions` WHERE assignmentID = ?");
$sth2 -> execute([$_SESSION['editingAssign']]);
$row = $sth2 -> fetch();

if (isset($_SESSION['editingAssign'])) {
    $question = $_SESSION['editingQuestion']+1;
    if ($sth2 -> rowCount() == $_SESSION['editingQuestion']) {
        $question = $_SESSION['editingQuestion'];
    }
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $question);
    exit();
}

$sth = $pdo -> prepare("INSERT INTO `answers` (studentID, answer, assignmentID, questionOrder) VALUES (?,?,?,?)");
$sth -> execute([$_SESSION['loggedID'],$_GET['answer'],$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$question = $_SESSION['editingQuestion'];
if ($sth2 -> rowCount() == $_SESSION['editingQuestion']) {
    header("Location: ../../Student/studentSite.php");
}

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']+1);
exit();