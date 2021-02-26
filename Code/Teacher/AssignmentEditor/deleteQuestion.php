<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
$row = $sth -> fetch();
if (isset($row['media'])) {
    unlink($row['media']);
}

$sth = $pdo -> prepare("DELETE FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

$sth2 = $pdo -> prepare("SELECT `order`, id FROM `questions` WHERE assignmentID = ? AND `order` > ?");
$sth2 -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
$row2 = $sth2 -> fetch();

do {
    $sth3 = $pdo -> prepare("UPDATE `questions` SET `order` = ? WHERE id = ?");
    $sth3 -> execute([$row2['order'] - 1, $row2['id']]);

} while ($row2 = $sth2 -> fetch());
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=1");
exit();