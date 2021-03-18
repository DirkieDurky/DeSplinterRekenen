<?php
require_once "DB_Connection.php";
session_start();

$sth1 = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ?");
$sth1 -> execute([$_SESSION['activeAssign']]);
$row1 = $sth1 -> fetch();



$correctAnswers = array();
do {
    switch ($row1['type']) {
        case 1:
            $sth2 = $pdo -> prepare("SELECT text FROM `multiplechoices` WHERE assignmentID = ? AND correct = ?");
            $sth2 -> execute([$_SESSION['activeAssign'],1]);
            $row2 = $sth2 -> fetch();
            $correctAnswers[] = $row2['text'];
            break;
        case 2:
            $sth3 = $pdo -> prepare("SELECT answer FROM `answerfields` WHERE assignmentID = ?");
            $sth3 -> execute([$_SESSION['activeAssign']]);
            $row3 = $sth3 -> fetch();
            $correctAnswers[] = $row3['answer'];
            break;
        case 3:
            $correctAnswers[] = eval("return " . $row1['sum'] . ";");
    }
} while ($row1 = $sth1 -> fetch());

$givenAnswers = array();

$sth4 = $pdo -> prepare("SELECT answer FROM `answers` WHERE assignmentID = ? AND studentID = ?");
$sth4 -> execute([$_SESSION['activeAssign'],$_SESSION['loggedID']]);
$row4 = $sth4 -> fetch();

do {
    $givenAnswers[] = $row4['answer'];
} while ($row4 = $sth4 -> fetch());

$correctlyGivenAnswers = array_intersect($correctAnswers, $givenAnswers);
$amountOfCorrectAnswers = sizeof($correctlyGivenAnswers);
$totalQuestionAmount = $sth1 -> rowCount();
$score = $amountOfCorrectAnswers / $totalQuestionAmount * 10;
$roundedScore = round($score,1);

$sth5 = $pdo -> prepare("UPDATE `results` SET score = ? WHERE assignmentID = ? AND studentID = ?");
$sth5 -> execute([$roundedScore,$_SESSION['activeAssign'],$_SESSION['loggedID']]);