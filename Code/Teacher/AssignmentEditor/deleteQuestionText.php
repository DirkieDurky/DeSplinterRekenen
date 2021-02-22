<?php
require_once "../../DB_Connection.php";
session_start();

$sth2 = $pdo->prepare("UPDATE `questions` SET text = '' WHERE assignmentID = ? AND `order` = ?");
$sth2->execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);