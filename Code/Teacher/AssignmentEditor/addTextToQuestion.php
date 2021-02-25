<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("UPDATE `questions` SET `text` = ? WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_GET['text'], $_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();