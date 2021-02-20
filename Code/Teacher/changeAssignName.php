<?php
require_once ("../DB_Connection.php");
session_start();

$sth2 = $pdo -> prepare("UPDATE `assignments` SET `name` = ? WHERE `id` = ?");
$sth2 -> execute([$_GET['changeName'], $_SESSION['editingAssign']]);
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign']);