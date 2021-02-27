<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_GET['question']]);
$row = $sth -> fetch();
if (isset($row['media'])) {
    unlink($row['media']);
}

$sth = $pdo -> prepare("DELETE FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_GET['question']]);

$sth2 = $pdo -> prepare("DELETE FROM multiplechoice WHERE assignmentID = ? AND `questionOrder` = ?");
$sth2 -> execute([$_SESSION['editingAssign'], $_GET['question']]);

$sth3 = $pdo -> prepare("SELECT `order`, id FROM `questions` WHERE assignmentID = ? AND `order` > ?");
$sth3 -> execute([$_SESSION['editingAssign'], $_GET['question']]);
$row3 = $sth3 -> fetch();

do {
    $sth4 = $pdo -> prepare("UPDATE `questions` SET `order` = ? WHERE id = ?");
    $sth4 -> execute([$row3['order'] - 1, $row3['id']]);

} while ($row3 = $sth3 -> fetch());
$question = $_GET['question'];
if ($_SESSION['editingQuestion'] == $_GET['question']) {
    $question = $_GET['question']-1;
}
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $question);
exit();