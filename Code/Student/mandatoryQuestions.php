<?php
    require_once "../DB_Connection.php";
    session_start();
    if (isset($_SESSION['editing'])) {
        unset($_SESSION['editing']);
    }
?>
<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../Css/style.css rel=stylesheet>
</head>
<body id="teacherSite">
<div class="studentField">
    <?php
        $sth1 = $pdo -> prepare("SELECT assignmentID FROM `results` WHERE studentID = ?");
        $sth1 -> execute([$_SESSION['loggedID']]);
        $row1 = $sth1 -> fetch();

        if (isset($row1['assignmentID'])) {
     do {
            $sth2 = $pdo -> prepare("SELECT id,name FROM `assignments` WHERE id = ?");
            $sth2 -> execute([$row1['assignmentID']]);
            $row2 = $sth2 -> fetch();

            ?>
            <div>
                <button onclick="<?= "window.location.href='../assignment.php?assign=" . $row2['id'] . "&question=1'"?>" class="collapsible" value="" name="continue">
                <?= $row2['name']?>
                <span id="continueIcon">-></span></button>
            </div>
    <?php
        } while ($row1 = $sth1 -> fetch());
        } else {
            echo "Geen verplichte opdrachten meer over!";
        }
    ?>
</div>
</body>
</html>