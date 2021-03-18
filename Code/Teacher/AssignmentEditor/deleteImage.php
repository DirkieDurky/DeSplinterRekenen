<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['activeAssign'], $_SESSION['activeQuestion']]);
$row = $sth -> fetch();
if (isset($row['media'])) {
    unlink($row['media']);
}

$sth2 = $pdo -> prepare("UPDATE `questions` SET media = '' WHERE assignmentID = ? AND `order` = ?");
$sth2 -> execute([$_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();