<?php
require_once "DB_Connection.php";

$sth = $pdo->prepare("SELECT `order` FROM `questions` WHERE assignmentID = ?;");
$sth -> execute([$_SESSION['activeAssign']]);
$row = $sth -> fetch();

$allQuestions = array();

do {
    $allQuestions[] = $row['order'];
} while ($row = $sth -> fetch());

$sth2 = $pdo -> prepare("SELECT questionOrder FROM `answers` WHERE studentID = ? AND assignmentID = ?");
$sth2 -> execute([$_SESSION['loggedID'],$_SESSION['activeAssign']]);
$row2 = $sth2 -> fetch();

$questionsAnswered = array();

do {
    $questionsAnswered[] = $row2['questionOrder'];
} while ($row2 = $sth2 -> fetch());

$questionsToBeAnswered = array_diff($allQuestions,$questionsAnswered);

if (empty($questionsToBeAnswered)) {
    echo "Alle vragen zijn beantwoord! Je wordt elk moment doorgestuurd naar de volgende pagina...";
    header("Location: gradeAssignment.php");
    exit();
}
?>
<!doctype html>
<html lang="nl">
<head>
    <title>Nog te beantwoorden vragen</title>
</head>
<body style="text-align:center">
    De volgende vragen zijn nog niet beantwoord:<br>
    <?php
    foreach($questionsToBeAnswered as $item) {
        echo $item . "<br>";
    }
    ?>
</body>
</html>
