<?php
require_once "../../DB_Connection.php";
session_start();

$sth1 = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth1 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);
$row1 = $sth1 -> fetch();
if (isset($row1['media']) && $row1['media'] != "") {
    unlink($row1['media']);
    $sth2 = $pdo->prepare("UPDATE `questions` SET `media` = ? WHERE id = ?");
    $sth2->execute(["", $_SESSION['editingAssign']]);
}
echo $_SESSION['editingAssign'];
echo $_GET['deleteQuestion'];

//Delete all elements in question
$sth2 = $pdo -> prepare("DELETE FROM multiplechoices WHERE assignmentID = ? AND `questionOrder` = ?");
$sth2 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);

$sth3 = $pdo -> prepare("DELETE FROM answerfields WHERE assignmentID = ? AND `questionOrder` = ?");
$sth3 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);

$sth4 = $pdo -> prepare("DELETE FROM answers WHERE assignmentID = ? AND `questionOrder` = ?");
$sth4 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);

//Delete question
$sth5 = $pdo -> prepare("DELETE FROM questions WHERE assignmentID = ? AND `order` = ?");
$sth5 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);

//change order of questions after deleted question {
$sth6 = $pdo -> prepare("SELECT `order`, id FROM `questions` WHERE assignmentID = ? AND `order` > ?");
$sth6 -> execute([$_SESSION['editingAssign'], $_GET['deleteQuestion']]);
$row6 = $sth6 -> fetch();

do {
    $sth7 = $pdo -> prepare("UPDATE `questions` SET `order` = ? WHERE id = ?");
    $sth7 -> execute([$row6['order'] - 1, $row6['id']]);
} while ($row6 = $sth6 -> fetch());
// }

$sth8 = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ?");
$sth8 -> execute([$_SESSION['editingAssign']]);
$row8 = $sth8 -> fetch();

if ($_GET['editingQuestion'] == 1) {
    $question = 2;
} else {
    $question = $_SESSION['editingQuestion'];
    if ($question > $sth8 -> rowCount()) {
        $question = $sth8 -> rowCount();
    }
}

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $question);
exit();