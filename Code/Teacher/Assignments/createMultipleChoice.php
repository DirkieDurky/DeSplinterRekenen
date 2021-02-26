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

$sth2 = $pdo -> prepare("DELETE FROM `multiplechoiceoptions` WHERE assignmentID = ? AND questionOrder = ?");
$sth2 -> execute([$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

$sth3 = $pdo -> prepare("INSERT INTO `multiplechoiceoptions` (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
$sth3 -> execute([$_GET['question'],1,0,$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);

for ($i = 0; $i < $boxesChecked; $i++) {
    if (isset($_GET['checkbox' . $i])) {
        $correct = 0;
        if (isset($_GET['correct' . $i])) {
            $correct = 1;
        }
        $sth4 = $pdo -> prepare("INSERT INTO `multiplechoiceoptions` (text, question , correct, assignmentID ,questionOrder) VALUES (?,?,?,?,?)");
        $sth4 -> execute([$_GET['answer' . $i],0,$correct,$_SESSION['editingAssign'],$_SESSION['editingQuestion']]);
    }
}
$_SESSION['notification'] = "Meerkeuzevraag toegevoegd.";
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();