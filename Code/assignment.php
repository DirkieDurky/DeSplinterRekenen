<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "DB_Connection.php";
require_once "defineRootDir.php";

$_SESSION['activeAssign'] = $_GET['assign'];
$_SESSION['activeQuestion'] = $_GET['question'];
?>
    <html lang="nl">
    <head>
        <title>Opdracht</title>
        <link rel="stylesheet" href="<?= CODE_DIR ?>/Css/style.css">
        <link rel="stylesheet" href="<?= CODE_DIR ?>/Css/assignments.css">
    </head>
    <body>
<?php

$sth = $pdo->prepare("SELECT * FROM `questions` WHERE assignmentID = ?;");
$sth->execute([$_SESSION['activeAssign']]);
$row = $sth->fetch();

if (!isset($row['id'])) {
?>

<?= "<script type=\"text/javascript\"> window.location.href = " . CODE_DIR . "'Teacher/AssignmentEditor/createQuestion.php';</script>" ?>
<?php
exit();
}
?>
<div class="linkButtons" id="questionSelectButtons">
    <?php
    $i = 1;
    do {
        $getSelectURL = $_SERVER['REQUEST_URI'];
        while (substr($getSelectURL, -1) != "=") {
            $getSelectURL = substr_replace($_SERVER['REQUEST_URI'], "", -1);
        }
        $getSelectURL .= $row['order']
        ?>
        <div id="questionButtonsContainer">
            <a class="linkButtons" id="questionSelectButton" href=<?= $getSelectURL ?>><?= $row['order'] ?></a><br>
            <?php
            if (isset($_SESSION['editing'])) {
            ?>
            <a class="linkButtons" id="questionDeleteButton"
               href="<?= CODE_DIR ?>/Teacher/AssignmentEditor/deleteQuestion.php?deleteQuestion=<?= $row['order']; ?>">x</a>
            <?php } ?>
        </div>
        <?php
        $i++;
    } while ($row = $sth->fetch());
    if (isset($_SESSION['editing'])) {
        ?>
        <a class="linkButtons" id="questionSelectButton" href="<?=CODE_DIR?>/Teacher/AssignmentEditor/createQuestion.php?question=<?= $i; ?>"><?= "+" ?></a>
        <?php
    }
    ?>
</div>
<div id="question">
    <?php
    include("question.php");
    ?>
</div>
    </body>
</html>