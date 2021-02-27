<?php
require_once "../../DB_Connection.php";
session_start();

if (!isset($_GET['answer'])) {
    $_SESSION['error'] = "Je hebt geen antwoord ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
    exit();
}

if (isset($_SESSION['editingAssign'])) {
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']+1);
    exit();
}

$sth = $pdo -> prepare("INSERT INTO `answers` (studentID, answer, assignmentID, questionOrder) VALUES (?,?,?,?)");
$sth -> execute([$_SESSION['loggedID'],$_GET['answer'],$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']+1);
exit();