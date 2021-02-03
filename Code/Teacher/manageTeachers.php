<?php
session_start();
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
    $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE teacher=1 AND id!=?");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['loggedID']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
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
} while($row = mysqli_fetch_array($result));
$_SESSION['i'] = $i;
?>
</table>
    <label><input id="teacherSaveButton" type="submit" value="Veranderingen opslaan"></label>
    </form>
    <?php } ?>
</div>
    <?php if (isset($_SESSION['notif'])){echo "<h3 class='notif'> " . $_SESSION['notif'] . " </h3>";} unset($_SESSION['notif'])?>
</body>
</html>