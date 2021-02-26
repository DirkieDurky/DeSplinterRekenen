<html lang="en">
<head>
    <title>Vraag</title>
    <link rel=stylesheet href="../../style.css">
</head>
<body>
<?php
require_once "../../DB_Connection.php";

$sth1 = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ? AND `order` = ?");
$sth1 -> execute([$_GET['assign'],$_GET['question']]);
$row1 = $sth1 -> fetch();

//Text
if (isset($row1['text'])) {
    echo $row1['text'] . "<br>";
}

//Get file name from location:
//Get the file location
$sth2 = $pdo -> prepare("SELECT `media` from `questions` WHERE assignmentID = ? AND `order` = ?");
$sth2 -> execute([$_GET['assign'], $_GET['question']]);
$row2 = $sth2 -> fetch();

//Remove directory
$slashLocation = strrpos($row2['media'], "/");
$fullFileName = substr($row2['media'], $slashLocation+1);

//Remove number from file
$underscoreLocation = strrpos($fullFileName, "_");

//Done!
$fileName = substr($fullFileName, $underscoreLocation+1);

//Image
?>
<img src="<?= $row2['media'] ?>" alt="<?= $fileName ?>"><br>
<?php
$sth3 = $pdo -> prepare("SELECT text FROM `multiplechoiceoptions` WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
$sth3 -> execute([$_GET['assign'],$_GET['question'],1]);
$row3 = $sth3 -> fetch();

//Multiple choice question
if (isset($row3['text'])){
    echo $row3['text'] . "<br>";
}

$sth4 = $pdo -> prepare("SELECT text FROM `multiplechoiceoptions` WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
$sth4 -> execute([$_GET['assign'],$_GET['question'],0]);
$row4 = $sth4 -> fetch();

//Multiple choice answers
do {
    if (isset($row4['text'])) {
        echo $row4['text'] . "<br>";
    }
} while ($row4 = $sth4 -> fetch());

if (isset($row1['sum']) && $row1['sum'] != "") {
    ?>
    <form action="answerCheck.php">
        <label>
            <?= $row1['sum'] . " =<br>" ?>
            <input type="text" name="sum">
        </label>
    </form>
    <?php
}

//Answer field
if (isset($row1['answer']) && $row1['answer'] != "") {
?>
<form action="answerCheck.php">
    <label>
        <input type="text" name="answer">
    </label>
</form>
<?php } ?>
</body>
</html>
