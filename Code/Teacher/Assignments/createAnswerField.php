<?php
require_once "../../DB_Connection.php";
session_start();

//Delete old questions
$sth1 = $pdo -> prepare("DELETE FROM `multiplechoice` WHERE assignmentID = ? AND questionOrder = ?");
$sth1 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth2 = $pdo -> prepare("DELETE FROM `answerFields` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth3 = $pdo -> prepare("UPDATE `questions` SET sum = ? WHERE assignmentID = ? AND `order` = ?");
$sth3 -> execute(["",$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

//Create new one
$sth4 = $pdo -> prepare("INSERT INTO `answerFields` (question, answer, unit, assignmentID, questionOrder) VALUES (?,?,?,?,?)");
$sth4 -> execute([$_GET['question'], $_GET['answer'], $_GET['unit'],$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
$_SESSION['notification'] = "Antwoord succesvol toegevoegd.";
exit();