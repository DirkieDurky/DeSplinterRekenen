<?php
require_once "../../DB_Connection.php";
session_start();

$sth4 = $pdo->prepare("DELETE FROM multiplechoices WHERE assignmentID = ? AND `questionOrder` = ?");
$sth4->execute([$_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();