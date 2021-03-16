<?php
require_once "../../DB_Connection.php";
session_start();
$sth = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ?");
$sth -> execute([$_SESSION['editingAssign']]);

$order = $sth -> rowCount() + 1;
$sth2 = $pdo -> prepare("INSERT INTO `questions` (`assignmentID`, `order`, `text`, `media`,`sum`) VALUES (?,?,?,?,?);");
$sth2 -> execute([$_SESSION['editingAssign'], $sth -> rowCount() + 1, "", "", ""]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $sth -> rowCount() + 1);
exit();