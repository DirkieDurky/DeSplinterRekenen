<?php
require_once "../../DB_Connection.php";

$sth = $pdo->prepare("SELECT * FROM `questions` WHERE assignmentID = ?;");
$sth->execute([$_SESSION['editingAssign']]);
$row = $sth->fetch();

if (!isset($row['id'])) {
?>

<script type="text/javascript"> window.location.href = 'createQuestion.php';</script>
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
            <a class="linkButtons" id="questionDeleteButton"
               href="deleteQuestion.php?deleteQuestion=<?= $row['order']; ?>">x</a>
        </div>
        <?php
        $i++;
    } while ($row = $sth->fetch());
    if (isset($_SESSION['editingAssign'])) {
        ?>
        <a class="linkButtons" id="questionSelectButton" href="createQuestion.php?question=<?= $i; ?>"><?= "+" ?></a>
        <?php
    }
    ?>
</div>
<div id="question">
    <?php
    include("question.php");
    ?>
</div>