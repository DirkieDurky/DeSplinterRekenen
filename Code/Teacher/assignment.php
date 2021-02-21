<?php
require_once "../DB_Connection.php";
require_once "Exercise.php";

    $sth = $pdo -> prepare("SELECT * FROM `exercises` WHERE assignmentID = ?;");
    $sth -> execute([$_SESSION['editingAssign']]);
    $row = $sth -> fetch();

if (!isset($row['id'])) {
header("Location: createExercise.php");
exit();
}
?>
<div id="exerciseSelectButtons">
<?php
$i = 1;
do {
    $getSelectURL = $_SERVER['REQUEST_URI'];
    while (substr($getSelectURL,-1) != "=") {
        $getSelectURL = substr_replace($_SERVER['REQUEST_URI'] ,"",-1);
    }
    $getSelectURL .= $row['order']
    ?>
    <div id="exerciseButtonsContainer">
        <a id="exerciseSelectButton" href=<?=$getSelectURL?>><?=$row['order']?></a><br>
        <a id="exerciseDeleteButton" href="deleteExercise.php?selected=<?= $row['order'];?>">x</a>
    </div>
    <?php
    $i++;
} while ($row = $sth -> fetch());
if (isset($_SESSION['editingAssign'])) {
    ?>
    <a id="exerciseSelectButton" href="createExercise.php?selected=<?= $i; ?>"><?="+"?></a>
    <?php
}
?>
</div>
<div id="exercise">
    <?php
    include("showExercise.php");
    ?>
</div>
