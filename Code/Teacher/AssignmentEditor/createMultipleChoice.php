<?php
require_once "../../DB_Connection.php";

for ($i = 0; $i < 6; $i++) {
    if (isset($_GET['checkbox' . $i])) {
        $correct = 0;
        if (isset($_GET['option' . $i])) {
            $correct = 1;
        }
        $sth = $pdo -> prepare("INSERT INTO `multiplechoiceoptions` (answer, correct, question_id) VALUES (?,?,?)");
        $sth -> execute([$_GET['textOption' . $i],$correct,$_SESSION['editingQuestion']]);
    }
}
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=1");
exit();