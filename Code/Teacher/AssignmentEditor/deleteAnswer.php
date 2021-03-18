<?php
require_once "../../DB_Connection.php";
session_start();

$sth = $pdo -> prepare("DELETE FROM `answerFields` WHERE assignmentID = ? AND questionOrder = ?");
$sth -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();