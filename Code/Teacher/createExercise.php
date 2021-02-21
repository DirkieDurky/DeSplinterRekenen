<?php
require_once "../DB_Connection.php";
session_start();
$sth = $pdo -> prepare("SELECT * FROM `exercises` WHERE assignmentID = ?");
$sth -> execute([$_SESSION['editingAssign']]);

$order = $sth -> rowCount() + 1;
$sth2 = $pdo -> prepare("INSERT INTO `exercises` (`assignmentID`, `order`, `text`, `media`, `question`, `answer`) VALUES (?,?,?,?,?,?);");
$sth2 -> execute([$_SESSION['editingAssign'], $sth -> rowCount() + 1, "", "", "", ""]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&selected=1");
exit();