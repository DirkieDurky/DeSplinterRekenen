<?php
require_once "../../DB_Connection.php";
session_start();

$public = 0;
$_SESSION['notification'] = "Opdracht is nu niet meer openbaar.";
if (isset($_GET['public'])) {
    $public = 1;
    $_SESSION['notification'] = "Opdracht is nu openbaar.";
}

$sth = $pdo -> prepare("UPDATE `assignments` SET public = ? WHERE id = ?");
$sth -> execute([$public,$_SESSION['editingAssign']]);

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();