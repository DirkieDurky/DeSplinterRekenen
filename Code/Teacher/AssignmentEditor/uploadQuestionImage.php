<?php
require_once "../../DB_Connection.php";
session_start();

//    if ($_FILES["fileToUpload"]["size"] > 500000) {
//        $_SESSION['error'] = "Sorry, de maximale bestandsgrootte is 5mb";
//    }
//    $imageFileType = pathinfo($_FILES['fileToUpload']['name'])['extension'];
//    if ($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//        $_SESSION['error'] = "Sorry, je kunt alleen PNG, JPG, JPEG, of GIF bestanden gebruiken.";
//    }
    $file = basename($_FILES["fileToUpload"]["name"]);

    $sth = $pdo -> prepare("SELECT `media` FROM questions WHERE assignmentID = ? AND `order` = ?");
    $sth -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
    $row = $sth -> fetch();
    if (isset($row['media'])) {
        unlink($row['media']);
    }

    $targetDir = "../Uploads/Images/QuestionImages/";
    $ext = "." . pathinfo($_FILES["fileToUpload"]["name"])['extension'];
    $fileName = pathinfo($_FILES["fileToUpload"]["name"])['filename'];
    $files = scandir('../Uploads/Images/QuestionImages/',SCANDIR_SORT_DESCENDING);
    if (!isset($files)) {
        $underscoreLocation = 0;
    } else {
        $underscoreLocation = strpos($files[0], "_");
    }
    $number = intval(substr($files[0], 0, $underscoreLocation))+1 . "_";
    $location = $targetDir . $number . $fileName . $ext;

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$location);
//    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$location)) {
//        $sth2 = $pdo -> prepare("UPDATE `questions` SET media = ? WHERE assignmentID = ? AND `order` = ?");
//        $sth2 -> execute([$location,$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
//
//        $_SESSION['notification'] = "Afbeelding succesvol geupload!";
//    } else {
//        $_SESSION['error'] = "Sorry, er ging iets mis bij het uploaden van je afbeelding.";
//    }

header("Location: assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion']);
exit();