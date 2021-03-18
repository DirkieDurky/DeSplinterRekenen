<?php
require_once "../../DB_Connection.php";
session_start();

$sth2 = $pdo->prepare("UPDATE `questions` SET sum = '' WHERE assignmentID = ? AND `order` = ?");
$sth2->execute([$_SESSION['activeAssign'], $_SESSION['activeQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();