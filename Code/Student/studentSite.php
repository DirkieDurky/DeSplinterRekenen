<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="teacherSite">
<div class="header">
    <div class="headerSelect">
        <a href="studentSite.php?selected=1"<?php if ($_GET['selected'] == 1){echo " id=\"selected\"";}?>>Verplichte opdrachten</a><a href="studentSite.php?selected=2"<?php if ($_GET['selected'] == 2){echo " id=\"selected\"";}?>>Alle opdrachten</a>
    </div>
    <div class="dropdown">
        <img src="../../unknownUser.png" alt="profPic" class="profPic">
        <div class="dropdown-cont">
            <a href="../logout.php">Uitloggen</a>
        </div>
    </div>
</div>
<?php
if ($_GET['selected'] == 1){
    include "mandatoryQuestions.php";
} else {
    include "allQuestions.php";
}
?>
</body>
</html>