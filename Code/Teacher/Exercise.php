<?php
class Exercise {
    function create($text = "", $media = "", $question = "", $answer = "") {
        require_once "../DB_Connection.php";
        $sth = $pdo -> prepare("SELECT * FROM `assignments` WHERE id = ?");
        $sth -> execute($_SESSION['editingAssign']);

        $order = $sth -> rowCount() + 1;
        $sth2 = $pdo -> prepare("INSERT INTO `exercises` (`assignmentID`, `order`, `text`, `media`, `question`, `answer`) VALUES (?,?,?,?,?,?);");
        $sth2 -> execute([$_SESSION['editingAssign'],$order , $text, $media, $question, $answer]);
    }

    function delete($id) {
        require_once "../DB_Connection.php";
        $sth3 = $pdo -> prepare("DELETE FROM `exercises` WHERE id = ?");
        $sth3 -> execute($id);
    }
}