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
    $sth1 = $pdo->prepare("SELECT id,name FROM `assignments` WHERE public = 1");
    $sth1->execute();
    $row1 = $sth1->fetch();

    if ($sth1->rowCount() < 1) {
        echo "Er zijn nog geen opdrachten gepubliceerd";
        exit();
    }
    ?>
    <div>
        <button onclick="<?= "window.location.href='../assignment.php?assign=" . $row1['id'] . "&question=1'" ?>"
                class="collapsible" value="" name="continue">
            <?= $row1['name'] ?>
            <span id="continueIcon">-></span></button>
    </div>
</div>
</body>
</html>