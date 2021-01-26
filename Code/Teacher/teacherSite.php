<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    session_start();
$conn = new mysqli("localhost", "root", "", "desplinterrekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE id=?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['loggedID']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>
<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="teacherSite">
<div class="header">
    <div class="headerSelect">
        <?php
        if ($row['perms'] == 2) {
            if (isset($_GET['selected'])){
                if ($_GET['selected'] == 0) {
                    echo "<a href=\"teacherSite.php?selected=0\" id=\"selected\">Leraren beheren</a>";
                } else {
                    echo "<a href=\"teacherSite.php?selected=0\">Leraren beheren</a>";
                }
            } else {
                echo "<a href=\"teacherSite.php?selected=0\" id=\"selected\">Leraren beheren</a>";
            }
        }?><!--
        --><a href="teacherSite.php?selected=1"<?php if (isset($_GET['selected'])) {if($_GET['selected'] == 1){echo " id=\"selected\"";}} ?>>Leerlingen beheren</a><!--
        --><a href="teacherSite.php?selected=2"<?php if (isset($_GET['selected'])) {if($_GET['selected'] == 2){echo " id=\"selected\"";}} ?>>Opdrachten toedienen</a><!--
        --><a href="teacherSite.php?selected=3"<?php if (isset($_GET['selected'])) {if($_GET['selected'] == 3){echo " id=\"selected\"";}} ?>>Resultaten inzien</a>
    </div>
    <div class="dropdown">
        <img src="../../unknownUser.png" alt="profPic" class="profPic">
        <div class="dropdown-cont">
            <a href="../logout.php">Uitloggen</a>
        </div>
    </div>
</div>
<?php
if ($row['perms'] == 0){
?>
    <div class="warning">
    <h3>Je mist de benodigde rechten om op deze pagina te zijn. Vraag aan een applicatiebeheerder om je de rechten te geven.</h3>
    </div>
<?php

} else {
switch ($_GET['selected']){
    case 0:
        if ($row['perms'] == 2){
            include "manageTeachers.php";
        } else {
            ?>
            <div class="warning">
                <h3>Je mist de benodigde rechten om op deze pagina te zijn. Vraag aan een applicatiebeheerder om je de rechten te geven.</h3>
            </div>
            <?php
        }
        break;
    case 1:
        include "manageStudents.php";
        break;
    case 2:
        include "Assignments.php";
        break;
    case 3:
        include "results.php";
        break;
}
}
?>
</body>
</html>