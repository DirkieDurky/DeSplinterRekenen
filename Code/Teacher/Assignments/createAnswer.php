<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("UPDATE `questions` SET `answer` = ? WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_GET['answer'], $_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
$_SESSION['notification'] = "Antwoord succesvol toegevoegd.";
exit();