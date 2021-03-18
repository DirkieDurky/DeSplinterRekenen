<?php
require_once "../../DB_Connection.php";
session_start();

if ($_GET['text'] == "") {
    $_SESSION['error'] = "Je hebt niks ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

$sth = $pdo -> prepare("UPDATE `questions` SET `text` = ? WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_GET['text'], $_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

$_SESSION['notification'] = "Tekst succesvol toegevoegd.";
header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();