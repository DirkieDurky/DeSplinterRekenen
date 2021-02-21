<?php
require_once "../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("DELETE FROM exercises WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['editingAssign'], $_GET['selected']]);

$sth2 = $pdo -> prepare("SELECT `order`, id FROM `exercises` WHERE assignmentID = ? AND `order` > ?");
$sth2 -> execute([$_SESSION['editingAssign'], $_GET['selected']]);
$row2 = $sth2 -> fetch();

do {
    $sth3 = $pdo -> prepare("UPDATE `exercises` SET `order` = ? WHERE id = ?");
    $sth3 -> execute([$row2['order'] - 1, $row2['id']]);

} while ($row2 = $sth2 -> fetch());
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&selected=1");
exit();