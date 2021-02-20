<?php
require_once ("../DB_Connection.php");
if (isset($_GET['submit'])) {
    $sth = $pdo -> prepare("INSERT INTO `groups` (name, studentCount) VALUE (?, 0)");
    $sth -> execute([$_GET['groupName']]);
}
header("Location: teacherSite.php?selected=1");