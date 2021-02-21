<?php
require_once "../DB_Connection.php";

    $sth = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ?;");
    $sth -> execute([$_SESSION['editingAssign']]);
    $row = $sth -> fetch();

if (!isset($row['id'])) {
header("Location: createQuestion.php");
exit();
}
?>
<div id="questionSelectButtons">
<?php
$i = 1;
do {
    $getSelectURL = $_SERVER['REQUEST_URI'];
    while (substr($getSelectURL,-1) != "=") {
        $getSelectURL = substr_replace($_SERVER['REQUEST_URI'] ,"",-1);
    }
    $getSelectURL .= $row['order']
    ?>
    <div id="questionButtonsContainer">
        <a id="questionSelectButton" href=<?=$getSelectURL?>><?=$row['order']?></a><br>
        <a id="questionDeleteButton" href="deleteQuestion.php?selected=<?= $row['order'];?>">x</a>
    </div>
    <?php
    $i++;
} while ($row = $sth -> fetch());
if (isset($_SESSION['editingAssign'])) {
    ?>
    <a id="questionSelectButton" href="createQuestion.php?selected=<?= $i; ?>"><?="+"?></a>
    <?php
}
?>
</div>
<div id="question">
    <?php
    include("showQuestion.php");
    ?>
</div>
