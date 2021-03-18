<?php
require_once "../../DB_Connection.php";
session_start();

//Delete old questions
$sth1 = $pdo -> prepare("DELETE FROM multiplechoices WHERE assignmentID = ? AND questionOrder = ?");
$sth1 -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$sth2 = $pdo -> prepare("DELETE FROM `answerFields` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$sth3 = $pdo -> prepare("UPDATE `questions` SET sum = ? WHERE assignmentID = ? AND `order` = ?");
$sth3 -> execute(["",$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

//Create new one
$sth4 = $pdo -> prepare("INSERT INTO `answerFields` (question, answer, unit, assignmentID, questionOrder) VALUES (?,?,?,?,?)");
$sth4 -> execute([$_GET['question'], $_GET['answer'], $_GET['unit'],$_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

$_SESSION['notification'] = "Antwoord succesvol toegevoegd.";
header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();