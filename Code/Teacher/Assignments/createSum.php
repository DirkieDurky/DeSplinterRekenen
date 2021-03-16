<?php
require_once "../../DB_Connection.php";
session_start();

if ($_GET['sum'] == "") {
    $_SESSION['error'] = "Je hebt niks ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
    exit();
}

//Delete old questions
$sth2 = $pdo -> prepare("DELETE FROM multiplechoices WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth2 = $pdo -> prepare("DELETE FROM `answerFields` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

//Create new one
$sth = $pdo -> prepare("UPDATE `questions` SET `sum` = ? WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_GET['sum'], $_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

$_SESSION['notification'] = "Som succesvol toegevoegd.";
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();