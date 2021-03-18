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
        <script type="text/javascript" src="notifications.js"></script>
    </head>
    <body>
<?php

$sth = $pdo->prepare("SELECT * FROM `questions` WHERE assignmentID = ?;");
$sth -> execute([$_SESSION['activeAssign']]);
$row = $sth->fetch();

if (!isset($row['id'])) {
?>

<?= "<script type=\"text/javascript\"> window.location.href = " . "'" . CODE_DIR . "/Teacher/AssignmentEditor/createQuestion.php';</script>" ?>
<?php
exit();
}
?>
<div class="linkButtons" id="questionSelectButtons">
    <?php
    $i = 1;
    do {
        $URL = $_SERVER['REQUEST_URI'];
        while (substr($URL, -1) != "=") {
            $URL = substr_replace($_SERVER['REQUEST_URI'], "", -1);
        }
        ?>
        <div id="questionButtonsContainer">
            <a class="linkButtons" id="questionSelectButton" href=<?= $URL . $row['order'] ?>><?= $row['order'] ?></a><br>
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
    }  else {
        ?>
        <a class="linkButtons" id="questionGradeButton" href=<?= $URL . ($sth -> rowCount() + 1) ?>>Controleren</a>
        <?php
    }
    ?>
</div>
<div id="question">
<?php
$sth = $pdo->prepare("SELECT * FROM `questions` WHERE assignmentID = ?");
$sth->execute([$_GET['assign']]);
$row = $sth->fetch();

if ($_GET['question'] > $sth -> rowCount()) {
    include "questionsToBeAnswered.php";
} else {
    include("question.php");
}
    ?>
</div>
<?php
if (!isset($_SESSION['editing'])) {
?>
<a class="backButton" id="assignment" href="Student/studentSite.php?selected=1"><-</a>
<?php
    }
    ?>
<?php
if (isset($_SESSION['notification'])) {
    echo "<h3 class='notification' id='notification'> " . $_SESSION['notification'] . " </h3>";
    unset($_SESSION['notification']); ?>
    <script> notifications('notification') </script>
<?php }

if (isset($_SESSION['error'])) {
    echo "<h3 class='notification' id='error'> " . $_SESSION['error'] . " </h3>";
    unset($_SESSION['error']); ?>
    <script> errors('error') </script>
<?php } ?>
    </body>
</html>