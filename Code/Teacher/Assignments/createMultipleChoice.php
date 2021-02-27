<?php
require_once "../../DB_Connection.php";
session_start();

if ($_GET['question'] == "") {
    $_SESSION['error'] = "Je hebt geen vraag ingevuld.";
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
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
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
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
    header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
    exit();
}

//Delete old questions
$sth1 = $pdo -> prepare("DELETE FROM `multiplechoice` WHERE assignmentID = ? AND questionOrder = ?");
$sth1 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth2 = $pdo -> prepare("DELETE FROM `answers` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth3 = $pdo -> prepare("UPDATE `questions` SET sum = ? WHERE assignmentID = ? AND `order` = ?");
$sth3 -> execute(["",$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

//Create new one
$sth4 = $pdo -> prepare("INSERT INTO `multiplechoice` (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
$sth4 -> execute([$_GET['question'],1,0,$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

for ($i = 0; $i < $boxesChecked; $i++) {
    if (isset($_GET['checkbox' . $i])) {
        $correct = 0;
        if (isset($_GET['correct' . $i])) {
            $correct = 1;
        }
        $sth5 = $pdo -> prepare("INSERT INTO `multiplechoice` (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
        $sth5 -> execute([$_GET['answer' . $i],0,$correct,$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);
    }
}

$sth6 = $pdo -> prepare("SELECT text FROM `multiplechoice` WHERE assignmentID = ? AND questionOrder = ?");
$sth6 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);
$row6 = $sth6 -> fetch();

if ($sth6 -> rowCount() == $boxesChecked+1) {
    $_SESSION['notification'] = "Meerkeuzevraag toegevoegd.";
} else {
    $_SESSION['error'] = "Sorry, er ging iets mis bij het maken van de meerkeuzevraag.";
}

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();