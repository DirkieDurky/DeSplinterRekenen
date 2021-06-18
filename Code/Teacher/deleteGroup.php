<?php
require_once "../DB_Connection.php";

$sth = $pdo -> prepare("SELECT * FROM `groups`");
$sth -> execute();
$groups = $sth -> fetch();

$sth2 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID != 1");
$sth2 -> execute();
$usersInGroup = $sth2 -> fetch();

for ($j = -1; $j < $groups['id'] || $j < $usersInGroup['id']; $j++, $groups = $sth -> fetch(), $usersInGroup = $sth2 -> fetch()) {
    //Remove group if asked
    if (isset ($_GET['deleteGroup' . $groups['id']])) {

        $sth3 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID = ?");
        $sth3 -> execute([$groups['id']]);
        $inThisGroup = $sth3 -> fetch();

        $sth4 = $pdo -> prepare("UPDATE `accounts` SET groupID = 1 WHERE id = ?");
        $sth4 -> execute([$inThisGroup['id']]);

        $sth5 = $pdo -> prepare("DELETE FROM `groups` WHERE id = ?");
        $sth5 -> execute([$groups['id']]);
    }
    //Remove user from group if asked
    if (isset ($_GET['deleteUser' . $usersInGroup['id']])){

        $sth5 = $pdo -> prepare("UPDATE `accounts` SET groupID = 1 WHERE id = ?");
        $sth5 -> execute([$usersInGroup['id']]);
        echo "user " . $usersInGroup['id'] . " deleted from group.<br>";
        }
    echo "user " . $usersInGroup['id'] . " not deleted from group.<br>";
    }
header("Location: teacherSite.php?selected=1");
exit();