<?php
require_once "../../DB_Connection.php";
session_start();

$sth4 = $pdo->prepare("DELETE FROM `multiplechoice` WHERE assignmentID = ? AND `questionOrder` = ?");
$sth4->execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();