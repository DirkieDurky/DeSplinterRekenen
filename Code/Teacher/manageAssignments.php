<?php
session_start();
require_once "../DB_Connection.php";
?>
<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../Css/style.css rel=stylesheet>
</head>
<body id="teacherSite">
<div class="teacherField">
    <h1>Opdrachten beheren</h1>
    <?php
    $sth4 = $pdo -> prepare("SELECT * FROM `assignments`");
    $sth4 -> execute();
    $row4 = $sth4 -> fetch();
    if (!$row4 == ""){
    ?>
    <form action="Assignments/deleteAssignment.php">
    <?php do { ?>
        <div>
                <button class="collapsible" value="<?= $row4['id']?>" name="continue">
                <label id="buttonDelete"><input type="submit" name="delete<?= $row4['id']; ?>" value=" "></label>
                <?= $row4['name']?>
                <span id="continueIcon">-></span></button>
        </div>
    <?php } while($row4 = $sth4 -> fetch());?>
        </form>
    <?php } ?>
    <form action="Assignments/createAssignment.php" id="createAssignForm" style="margin-bottom:20px;">
        <input type="hidden" name="selected" value="2">
        <label>
            Maak een nieuwe opdracht met de naam
            <input type="text" name="assignmentName" placeholder="naam">
        </label>
        <input type="submit" name="createAssignButton" value="->">
    </form>
    <h4 class="error" id="assignments"><?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>