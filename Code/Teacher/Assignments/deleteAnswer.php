<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("DELETE FROM `answers` WHERE assignmentID = ? AND questionOrder = ?");
$sth -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();