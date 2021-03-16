<?php
require_once "../../DB_Connection.php";
session_start();
$_SESSION['error'] = "Oeps... Er ging iets mis... Sorry!";

//Update groups
$sth2 = $pdo->prepare("SELECT * FROM `groups` WHERE id != 1");
$sth2->execute();
$row2 = $sth2->fetch();

do {
    if (isset($_GET['selectGroup' . $row2['id']])) {
        $sth10 = $pdo -> prepare("SELECT id FROM `accounts` WHERE groupID = ?");
        $sth10 -> execute([$row2['id']]);
        $row10 = $sth10 -> fetch();

        do {
            $sth16 = $pdo -> prepare("SELECT id FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth16 -> execute([$row10['id'], $_SESSION['editingAssign']]);

            if ($sth16 -> rowCount() == 0) {
                $sth11 = $pdo -> prepare("INSERT INTO results (studentID, assignmentID, score) VALUES (?,?,?)");
                $sth11 -> execute([$row10['id'], $_SESSION['editingAssign'], ""]);

                $_SESSION['notification'] = "Opdracht succesvol toegediend";

                echo $row10['id'] . "<br>";
                echo $_SESSION['editingAssign'] . "<br>";
            }
        } while ($row10 = $sth10 -> fetch());
    } else {
        $sth13 = $pdo -> prepare("SELECT id FROM `accounts` WHERE groupID = ?");
        $sth13 -> execute([$row2['id']]);
        $row13 = $sth13 -> fetch();

        do {
            $sth11 = $pdo -> prepare("DELETE FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth11 -> execute([$row13['id'], $_SESSION['editingAssign']]);
            $_SESSION['notification'] = "Opdracht toedienen succesvol ongedaan gemaakt";
        } while ($row13 = $sth13 -> fetch());
    }

    //Update users in group
    $sth30 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID = ?");
    $sth30 -> execute([$row2['id']]);
    $row30 = $sth30 -> fetch();

    do {
        if (isset($_GET['selectInGroup' . $row30['id']])) {
            $sth33 = $pdo -> prepare("SELECT id FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth33 -> execute([$row30['id'], $_SESSION['editingAssign']]);

            if ($sth33 -> rowCount() == 0) {
                $sth31 = $pdo -> prepare("INSERT INTO results (studentID, assignmentID, score) VALUES (?,?,?)");
                $sth31->execute([$row30['id'], $_SESSION['editingAssign'], ""]);
                $_SESSION['notification'] = "Opdracht succesvol toegediend";
            }
        } else {
            $sth32 = $pdo -> prepare("DELETE FROM results WHERE studentID = ? AND assignmentID = ?");
            $sth32->execute([$row30['id'], $_SESSION['editingAssign']]);
            $_SESSION['notification'] = "Opdracht toedienen succesvol ongedaan gemaakt";
        }
    } while ($row30 = $sth30 -> fetch());

} while ($row2 = $sth2->fetch());

//Update students not in a group
$sth3 = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0 AND groupID=1");
$sth3 -> execute();
$row3 = $sth3 -> fetch();

do {
    if (isset($_GET['selectNotInGroup' . $row3['id']])) {
        $sth41 = $pdo -> prepare("SELECT id FROM results WHERE studentID = ? AND assignmentID = ?");
        $sth41 -> execute([$row3['id'], $_SESSION['editingAssign']]);

        if ($sth41 -> rowCount() == 0) {
            $sth4 = $pdo -> prepare("INSERT INTO results (studentID, assignmentID, score) VALUES (?,?,?)");
            $sth4->execute([$row3['id'], $_SESSION['editingAssign'], ""]);
            $_SESSION['notification'] = "Opdracht succesvol toegediend";
        }
    } else {
        $sth5 = $pdo -> prepare("DELETE FROM results WHERE studentID = ? AND assignmentID = ?");
        $sth5 -> execute([$row3['id'], $_SESSION['editingAssign']]);
        $_SESSION['notification'] = "Opdracht toedienen succesvol ongedaan gemaakt";
    }
} while ($row3 = $sth3 -> fetch());

if (isset($_SESSION['notification'])) {unset($_SESSION['error']);}
//header("Location: assignAssignment.php");
exit();