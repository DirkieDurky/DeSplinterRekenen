<?php
require_once "../../DB_Connection.php";
require_once "../../Css/rightSideElements.php";
?>
<html lang="en">
<head>
    <title>Vraag</title>
    <link rel=stylesheet href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/assignments.css">
</head>
<body>
<?php
$sth1 = $pdo->prepare("SELECT * FROM `questions` WHERE assignmentID = ? AND `order` = ?");
$sth1->execute([$_GET['assign'], $_GET['question']]);
$row1 = $sth1->fetch();

//Get file name from location:
//Get the file location
$sth2 = $pdo->prepare("SELECT `media` from `questions` WHERE assignmentID = ? AND `order` = ?");
$sth2->execute([$_GET['assign'], $_GET['question']]);
$row2 = $sth2->fetch();

//Remove directory
$slashLocation = strrpos($row2['media'], "/");
$fullFileName = substr($row2['media'], $slashLocation + 1);

//Remove number from file
$underscoreLocation = strrpos($fullFileName, "_");

//Done!
$fileName = substr($fullFileName, $underscoreLocation + 1);

//Image
if (isset($row2['media']) && $row2['media'] != "") {
    if ($row2['media'] != "") {
        ?>
        <div class="element" id="imgContainer">
            <img id="questionImg" src="<?= $row2['media'] ?>" alt="<?= $fileName ?>">
            <a class="linkButtons" id="imgDeleteButton" href="deleteImage.php">x</a><br>
        </div>
    <?php }
}

//Questions:
//Text
if (isset($row1['text']) && $row1['text'] != "") {
    ?>
    <p class="element rightSideElement" id="text"><?= $row1['text'] ?>
        <a class="linkButtons" id="textDeleteButton" href="deleteText.php">x</a>
    </p>
    <br>
    <?php
}

//Multiple choice
$sth3 = $pdo->prepare("SELECT text FROM `multiplechoice` WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
$sth3->execute([$_GET['assign'], $_GET['question'], 1]);
$row3 = $sth3->fetch();

if (isset($row3['text']) && $row3['text'] != "") {
    ?>
    <div class="element rightSideElement" id="multipleChoice">
        <?php
        //Multiple choice question
        echo $row3['text'] . "<br>";

        //Multiple choice answers
        $sth4 = $pdo->prepare("SELECT text FROM `multiplechoice` WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
        $sth4->execute([$_GET['assign'], $_GET['question'], 0]);
        $row4 = $sth4->fetch();

        do {
            if (isset($row4['text']) && $row4['text'] != "") {
                ?>
                <a class="linkButtons" id="multipleChoiceSelect"
                   href="answerCheck.php?answer=<?= $row4['text'] ?>"><?= $row4['text'] . "<br>" ?></a>
                <?php
                $i++;
            }
        } while ($row4 = $sth4->fetch());
        ?>
        <a class="linkButtons" id="MTPCDeleteButton" href="deleteMultipleChoice.php">x</a>
    </div>
    <?php
}
//Answer field
$sth5 = $pdo->prepare("SELECT `question`, `answer`, `unit` FROM `answers` WHERE assignmentID = ? AND `questionOrder` = ?");
$sth5->execute([$_GET['assign'], $_GET['question']]);
$row5 = $sth5->fetch();

if (isset($row5['answer']) && $row5['answer'] != "") {
    ?>
    <div class="element rightSideElement" id="answerField">
        <form action="answerCheck.php" style="margin:0">
            <label>
                <?= $row5['question'] . "<br>" ?>
                <input type="text" name="answer"><?= " " . $row5['unit'] ?>
            </label>
        </form>
        <a class="linkButtons" id="answerDeleteButton" href="deleteAnswer.php">x</a>
    </div>
<?php }

//Som
if (isset($row1['sum']) && $row1['sum'] != "") {
    ?>
    <div class="element rightSideElement" id="sum">
        <form action="answerCheck.php" style="margin:0">
            <label>
                <?= $row1['sum'] . " =<br>" ?>
                <input type="text" name="answer">
            </label>
        </form>
        <a class="linkButtons" id="sumDeleteButton" href="deleteSum.php">x</a>
    </div>
<?php } ?>
</body>
</html>
