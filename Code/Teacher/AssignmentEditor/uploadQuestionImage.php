<?php
session_start();

function uploadImage()
{
    require_once "../../DB_Connection.php";

    $file = basename($_FILES["fileToUpload"]["name"]);
    $ext = "." . strtolower(pathinfo($file)['extension']);
    $targetDir = "../../Uploads/Images/QuestionImages/";
    $fileName = pathinfo($file)['filename'];
    $files = scandir($targetDir, SCANDIR_SORT_DESCENDING);

    if ($ext != "png" && $ext != "jpg" && $ext != "jpeg" && $ext != "gif") {
        $_SESSION['error'] = "Sorry, je afbeelding kan alleen een van de volgende extenties hebben: png, jpg, jpeg of gif.";
        return;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $_SESSION['error'] = "Sorry, je afbeelding kan maximaal 5mb zijn.";
        return;
    }

    $sth = $pdo->prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
    $sth->execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
    $row = $sth->fetch();
    if (isset($row['media'])) {
        unlink($row['media']);
    }

    if (!isset($files)) {
        $underscoreLocation = 0;
    } else {
        $underscoreLocation = strpos($files[0], "_");
    }
    $number = intval(substr($files[0], 0, $underscoreLocation)) + 1 . "_";
    $location = $targetDir . $number . $fileName . $ext;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $location)) {
        $sth2 = $pdo->prepare("UPDATE `questions` SET media = ? WHERE assignmentID = ? AND `order` = ?");
        $sth2->execute([$location, $_SESSION['editingAssign'], $_SESSION['editingQuestion']]);

        $_SESSION['notification'] = "Afbeelding succesvol geupload!";
    } else {
        $_SESSION['notification'] = "Er ging iets mis bij het uploaden van je afbeelding.";
    }
    return;
}
uploadImage();
header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();