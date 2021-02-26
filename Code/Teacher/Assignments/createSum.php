<?php
require_once "../../DB_Connection.php";
session_start();

if ($_GET['sum'] == "") {
    $_SESSION['error'] = "Je hebt niks ingevuld";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
    exit();
}

$sth = $pdo -> prepare("UPDATE `questions` SET `sum` = ? WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_GET['sum'], $_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

$_SESSION['notification'] = "Som succesvol toegevoegd.";
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();