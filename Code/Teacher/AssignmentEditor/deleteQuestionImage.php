<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
$row = $sth -> fetch();
if (isset($row['media'])) {
    unlink($row['media']);
}

$sth2 = $pdo -> prepare("UPDATE `questions` SET media = '' WHERE assignmentID = ? AND `order` = ?");
$sth2 -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();