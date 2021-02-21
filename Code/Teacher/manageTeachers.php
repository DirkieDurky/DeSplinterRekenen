<?php
session_start();
require_once "../DB_Connection.php";
?>
<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body>
<div class="teacherField">
<h1>Leraren beheren</h1>
Als applicatiebeheerder kunt u hier bepalen welke rechten leraren krijgen. <br>
Iedereen kan zomaar een account aanmaken, dus niet iedereen kan natuurlijk rechten krijgen!<br>
<br>
Hier kunt u leraren de volgende rechten geven:<br>
Geen (G):<br>
    Leraren met deze instelling kunnen niks.<br>
<br>
Standaard (S):<br>
    Leraren met deze instelling kunnen het volgende:<br>
<ul>
    <li>Leerlingen beheren.</li>
    <li>Leerlingen opdrachten geven.</li>
    <li>Resultaten van leerlingen inzien.</li>
</ul>
<br>
Applicatiebeheerder (AB):
    <ul>
        <li>Leerlingen beheren.</li>
        <li>Leerlingen opdrachten geven.</li>
        <li>Resultaten van leerlingen inzien.</li>
        <li>Leraren te beheren.</li>
    </ul>
    <?php
    $sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=1 AND id!=?");
    $sth -> execute([$_SESSION['loggedID']]);
    $row = $sth -> fetch();
    if ($row == ""){
        echo "<h3 class='teachers'>Er zijn geen leraren om te beheren.</h3>";
    } else {
    ?>
    <form action="manageTeachersSave.php">
<table class="table" id="teachers">
    <tr>
        <th>G</th>
        <th>L</th>
        <th>AB</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Email</th>
    </tr>
<?php

$i = 0;
do {
    echo "<tr>";
    ?>
    <td class="permsRadio"><label><input type="radio" name="perms<?php echo $i;?>" value="0" <?php if($row['perms'] == 0){echo "checked";}?>></label></td>
    <td class="permsRadio"><label><input type="radio" name="perms<?php echo $i;?>" value="1" <?php if($row['perms'] == 1){echo "checked";}?>></label></td>
    <td class="permsRadio"><label><input type="radio" name="perms<?php echo $i;?>" value="2" <?php if($row['perms'] == 2){echo "checked";}?>></label></td>
    <?php
    echo "<td>" . $row['firstName'] . "</td>";
    echo "<td>" . $row['lastName'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "</tr>";
    $i++;
} while($row = $sth -> fetch());
$_SESSION['i'] = $i;
?>
</table>
    <label><input id="teacherSaveButton" type="submit" value="Veranderingen opslaan"></label>
    </form>
    <?php } ?>
</div>
    <?php if (isset($_SESSION['notification'])){echo "<h3 class='notification'> " . $_SESSION['notification'] . " </h3>";} unset($_SESSION['notification'])?>
</body>
</html>