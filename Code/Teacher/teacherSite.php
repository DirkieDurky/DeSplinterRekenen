<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="teacherSite">
<div class="header">
    <div class="headerSelect">
        <?php session_start();
        if ($_SESSION['appMan'] == TRUE) {
            if ($_GET['selected'] == 0) {
                echo "<a href=\"teacherSite.php?selected=0\" id=\"selected\">Leraren beheren</a>";
            } else {
                echo "<a href=\"teacherSite.php?selected=0\">Leraren beheren</a>";
            }}?><!--
        --><a href="teacherSite.php?selected=1"<?php if ($_GET['selected'] == 1){echo " id=\"selected\"";}?>>Leerlingen beheren</a><!--
        --><a href="teacherSite.php?selected=2"<?php if ($_GET['selected'] == 2){echo " id=\"selected\"";}?>>Geef leerlingen opdrachen</a><!--
        --><a href="teacherSite.php?selected=3"<?php if ($_GET['selected'] == 3){echo " id=\"selected\"";}?>>Resultaten inzien</a>
    </div>
    <div class="dropdown">
        <img src="../../unknownUser.png" alt="profPic" class="profPic">
        <div class="dropdown-cont">
            <a href="../logout.php">Uitloggen</a>
        </div>
    </div>
</div>
<?php
switch ($_GET['selected']){
    case 1:
        include "manageStudents.php";
    break;
    case 2:
        include "assignTests.php";
    break;
    case 3:
        include "results.php";
    break;
}
?>
</body>
</html>