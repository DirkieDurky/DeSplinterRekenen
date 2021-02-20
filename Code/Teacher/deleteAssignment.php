<?php
require_once "../DB_Connection.php";

$sth = $pdo -> prepare("SELECT * FROM `assignments`");
$sth -> execute();
$row = $sth -> fetch();

for ($i=0;$i<$sth -> rowCount();$i++, $row = $sth -> fetch()) {
    if (isset($_GET['delete' . $row['id']])) {
        $sth = $pdo -> prepare("DELETE FROM `assignments` WHERE id = ?");
        $sth -> bindParam($sth, $row['id']);
        $sth -> execute();
        echo "deleted assignment with id " . $row['id'] . "<br>";
    } else {
        echo "Assignment with id " . $row['id'] . " was not clicked<br>";
    }
}
//header("Location: teacherSite.php?selected=2");
exit();