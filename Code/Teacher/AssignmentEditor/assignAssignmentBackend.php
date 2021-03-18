<?php
require_once "../../DB_Connection.php";
session_start();

//Update groups
$sth1 = $pdo->prepare("SELECT * FROM `groups` WHERE id != 1");
$sth1->execute();
$row1 = $sth1->fetch();

do {

    //Update users in group
    $sth2 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID = ?");
    $sth2 -> execute([$row1['id']]);
    $row2 = $sth2 -> fetch();

    do {
        if (isset($_GET['selectInGroup' . $row2['id']])) {
            $sth3 = $pdo -> prepare("SELECT id FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth3 -> execute([$row2['id'], $_SESSION['activeAssign']]);

            if ($sth3 -> rowCount() == 0) {
                $sth4 = $pdo -> prepare("INSERT INTO results (studentID, assignmentID, score) VALUES (?,?,?)");
                $sth4->execute([$row2['id'], $_SESSION['activeAssign'], ""]);
            }
        } else {
            $sth5 = $pdo -> prepare("DELETE FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth5->execute([$row2['id'], $_SESSION['activeAssign']]);
        }
    } while ($row2 = $sth2 -> fetch());

} while ($row1 = $sth1->fetch());

//Update students not in a group
$sth6 = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0 AND groupID=1");
$sth6 -> execute();
$row6 = $sth6 -> fetch();

do {
    if (isset($_GET['selectNotInGroup' . $row6['id']])) {
        $sth7 = $pdo -> prepare("SELECT id FROM results WHERE studentID = ? AND assignmentID = ?");
        $sth7 -> execute([$row6['id'], $_SESSION['activeAssign']]);

        if ($sth7 -> rowCount() == 0) {
            $sth8 = $pdo -> prepare("INSERT INTO results (studentID, assignmentID, score) VALUES (?,?,?)");
            $sth8->execute([$row6['id'], $_SESSION['activeAssign'], ""]);
        }
    } else {
        $sth9 = $pdo -> prepare("DELETE FROM results WHERE studentID = ? AND assignmentID = ?");
        $sth9 -> execute([$row6['id'], $_SESSION['activeAssign']]);
    }
} while ($row6 = $sth6 -> fetch());

$_SESSION['notification'] = "Veranderingen succesvol aangepast";
header("Location: assignAssignment.php");
exit();