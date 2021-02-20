<?php
require_once ("../DB_Connection.php");

$sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0");
$sth -> execute();
$row = $sth -> fetch();

$sth2 = $pdo -> prepare("SELECT * FROM `groups` WHERE name = ?");
$sth2 -> execute([$_GET['groups']]);
$row2 = $sth2 -> fetch();

echo "There were " . $sth -> rowCount() . " boxes to be checked<br>";

for ($i=0; $i<$sth -> rowCount(); $i++, $row = $sth2 -> fetch()) {
    if (isset($_GET['select' . $row['id']])) {
        $sth = $pdo -> prepare("UPDATE `accounts` SET groupID = ? WHERE id = ?");
        $sth -> execute([$row2['id'], $row['id']]);
    } else {
        echo "select" . $row['id'] . " was not checked<br>";
    }
}
header("Location: teacherSite.php?selected=1");