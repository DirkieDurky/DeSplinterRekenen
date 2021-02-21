<?php
    require_once "../DB_Connection.php";
    session_start();

    if (strlen($_GET['assignmentName'])==0) {
        $_SESSION['error'] =  "De naam van je opdracht moet minstens 1 karakter bevatten.";
        header("Location: teacherSite.php?selected=2");
        exit();
    }

    if (strlen($_GET['assignmentName'])>35) {
        $_SESSION['error'] =  "De naam van je opdracht kan maximaal 35 karakters bevatten.";
        header("Location: teacherSite.php?selected=2");
        exit();
    }

    $sth = $pdo->prepare("INSERT INTO `assignments` (`name`,`creatorID`) VALUES (?,?)");
    $sth -> execute([$_GET['assignmentName'], $_SESSION['loggedID']]);
    unset($_GET['createAssignButton']);
    echo "Redirecting you to the assignment with id " . $pdo -> lastInsertId() . "...";
    header("Location: teacherSite.php?selected=2");
