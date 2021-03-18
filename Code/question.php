<?php
require_once "defineRootDir.php";
require_once "DB_Connection.php";
require_once "Css/rightSideElements.php";
?>
<html lang="nl">
<head>
    <title>Vraag</title>
    <link rel=stylesheet href="Css/style.css">
    <link rel="stylesheet" href="Css/assignments.css">
</head>
<body>
<?php


if (isset($_SESSION['editing'])) {
?>
<style>
    .element:hover {
        outline: solid blue 3px;
    }
</style>
<?php }

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
            <img src="<?= ROOT_DIR . $row2['media'] ?>" alt="<?= $fileName ?>">
            <?php
            if (isset($_SESSION['editing'])) {
            ?>
            <a class="linkButtons" id="imgDeleteButton" href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteImage.php">x</a><br>
            <?php } ?>
        </div>
    <?php }
}

//Text
if (isset($row1['text']) && $row1['text'] != "") {
    ?>
    <p class="element rightSideElement" id="text"><?= $row1['text'] ?>
        <?php
        if (isset($_SESSION['editing'])) {
        ?>
        <a class="linkButtons" id="textDeleteButton" href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteText.php">x</a>
        <?php } ?>
    </p>
    <br>
    <?php
}

//Answer fields:
//Multiple choice
$sth3 = $pdo->prepare("SELECT text FROM multiplechoices WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
$sth3->execute([$_GET['assign'], $_GET['question'], 1]);
$row3 = $sth3->fetch();

if (isset($row3['text']) && $row3['text'] != "") {
    ?>
    <div class="element rightSideElement" id="multipleChoice">
        <?php
        //Multiple choice question
        echo $row3['text'] . "<br>";

        //Multiple choice answers
        $sth4 = $pdo->prepare("SELECT text FROM multiplechoices WHERE assignmentID = ? AND `questionOrder` = ? AND `question` = ?");
        $sth4->execute([$_GET['assign'], $_GET['question'], 0]);
        $row4 = $sth4->fetch();

        ?>
        <form action="<?= CODE_DIR ?>/addAnswer.php" class="radioButtons" style="margin:0">
            <?php
            $i = 0;
            do {
                ?>
                    <input type="radio" name="answer" id="<?= $i ?>" value="<?= $row4['text'] ?>">
                    <label for="<?= $i ?>"><?= $row4['text'] ?></label>
                <?php
                $i++;
            } while ($row4 = $sth4->fetch());
            ?>
            <input type="submit" value="->">
        </form>
        <?php
        if (isset($_SESSION['editing'])) {
        ?>
        <a class="linkButtons" id="MTPCDeleteButton" href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteMultipleChoice.php">x</a>
        <?php } ?>
    </div>
    <?php
}
//Answer field
$sth5 = $pdo->prepare("SELECT `question`, `answer`, `unit` FROM `answerFields` WHERE assignmentID = ? AND `questionOrder` = ?");
$sth5->execute([$_GET['assign'], $_GET['question']]);
$row5 = $sth5->fetch();

if (isset($row5['answer']) && $row5['answer'] != "") {
    ?>
    <div class="element rightSideElement" id="answerField">
        <form action="<?= CODE_DIR ?>/addAnswer.php" style="margin:0">
            <label>
                <?= $row5['question'] . "<br>" ?>
                <input type="text" name="answer" ><?= " " . $row5['unit'] ?>
            </label>
            <br>
            <input type="submit" value="->">
        </form>
        <?php
        if (isset($_SESSION['editing'])) {
        ?>
        <a class="linkButtons" id="answerDeleteButton" href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteAnswer.php">x</a>
        <?php } ?>
    </div>
<?php }

//Som
if (isset($row1['sum']) && $row1['sum'] != "") {
    ?>
    <div class="element rightSideElement" id="sum">
        <form action="<?= CODE_DIR ?>/addAnswer.php" style="margin:0">
            <label>
                <?= $row1['sum'] . " =<br>" ?>
                <input type="text" name="answer" required>
            </label>
            <br>
            <input type="submit" value="->">
        </form>
        <?php
        if (isset($_SESSION['editing'])) {
        ?>
        <a class="linkButtons" id="sumDeleteButton" href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteSum.php">x</a>
        <?php } ?>
    </div>
<?php } ?>
</body>
</html>