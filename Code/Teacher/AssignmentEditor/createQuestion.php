<?php
require_once "../../DB_Connection.php";
session_start();
$sth = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ?");
$sth -> execute([$_SESSION['activeAssign']]);

$order = $sth -> rowCount() + 1;
$sth2 = $pdo -> prepare("INSERT INTO `questions` (`assignmentID`, `type`, `order`, `text`, `media`,`sum`) VALUES (?,?,?,?,?,?);");
$sth2 -> execute([$_SESSION['activeAssign'], 0, $sth -> rowCount() + 1, "", "", ""]);

$newQuestion = $sth -> rowCount() + 1;
header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $newQuestion);
exit();