<?php
require_once "../../DB_Connection.php";
session_start();

if ($_GET['question'] == "") {
    $_SESSION['error'] = "Je hebt geen vraag ingevuld.";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

$boxesChecked = 0;
for ($i = 0; $i < 6; $i++) {
    if (isset($_GET['checkbox' . $i])) {
        $boxesChecked++;
    }
}

$answerCheck = 0;
for ($i = 0; $i < $boxesChecked; $i++) {
    if ($_GET['answer' . $i] == "") {
        $answerCheck++;
    }
}

if ($answerCheck == $boxesChecked) {
    $_SESSION['error'] = "Je hebt geen antwoord ingevuld.";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

$correctCheck = 0;
for ($i = 0; $i < $boxesChecked; $i++) {
    if (!isset($_GET['correct' . $i])) {
        $correctCheck++;
    }
}

if ($correctCheck == $boxesChecked) {
    $_SESSION['error'] = "Je hebt geen juist antwoord geselecteerd.";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
    exit();
}

//Delete old questions
$sth1 = $pdo -> prepare("DELETE FROM multiplechoices WHERE assignmentID = ? AND questionOrder = ?");
$sth1 -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$sth2 = $pdo -> prepare("DELETE FROM `answerFields` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

$sth3 = $pdo -> prepare("UPDATE `questions` SET sum = ? WHERE assignmentID = ? AND `order` = ?");
$sth3 -> execute(["",$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

//Create new one
$sth4 = $pdo -> prepare("INSERT INTO multiplechoices (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
$sth4 -> execute([$_GET['question'],1,0,$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);

for ($i = 0; $i < $boxesChecked; $i++) {
    if (isset($_GET['checkbox' . $i])) {
        $correct = 0;
        if (isset($_GET['correct' . $i])) {
            $correct = 1;
        }
        $sth5 = $pdo -> prepare("INSERT INTO multiplechoices (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
        $sth5 -> execute([$_GET['answer' . $i],0,$correct,$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);
    }
}

$sth6 = $pdo -> prepare("SELECT text FROM multiplechoices WHERE assignmentID = ? AND questionOrder = ?");
$sth6 -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);
$row6 = $sth6 -> fetch();

if ($sth6 -> rowCount() == $boxesChecked+1) {
    $_SESSION['notification'] = "Meerkeuzevraag toegevoegd.";
} else {
    $_SESSION['error'] = "Sorry, er ging iets mis bij het maken van de meerkeuzevraag.";
}

header("Location: assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion']);
exit();