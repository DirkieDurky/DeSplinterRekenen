<?php
require_once "../../DB_Connection.php";
session_start();

$sth2 = $pdo -> prepare("UPDATE `assignments` SET `name` = ? WHERE `id` = ?");
$sth2 -> execute([$_GET['changeName'], $_SESSION['editingAssign']]);
$_SESSION['notification'] = "Naam van opdracht succesvol aangepast";
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();