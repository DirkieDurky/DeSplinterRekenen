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
<h1 class="title">Leraren beheren</h1>
Als applicatiebeheerder kunt u hier bepalen welke rechten leraren krijgen. Iedereen kan zomaar een account aanmaken, dus niet iedereen kan natuurlijk rechten krijgen!<br>
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
    <form action="manageTeachersSave.php">
<table class="teachers">
    <tr>
        <th>G</th>
        <th>L</th>
        <th>AB</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Email</th>
    </tr>
<?php
$teacher = 1;
$teacher2 = 2;
$conn = new mysqli("localhost", "root", "", "desplinterrekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE (teacher=? OR teacher=?) AND id!=?");
mysqli_stmt_bind_param($stmt, "iii", $teacher, $teacher2, $_SESSION['loggedID']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$_SESSION['teachRow'] = mysqli_fetch_assoc($result);

$i = 0;
do {
    echo "<tr>";
    ?>
    <td><label><input type="radio" name="perms<?php echo $i;?>" value="0" <?php if($_SESSION['teachRow']['perms'] == 0){echo "checked";}?>></label></td>
    <td><label><input type="radio" name="perms<?php echo $i;?>" value="1" <?php if($_SESSION['teachRow']['perms'] == 1){echo "checked";}?>></label></td>
    <td><label><input type="radio" name="perms<?php echo $i;?>" value="2" <?php if($_SESSION['teachRow']['perms'] == 2){echo "checked";}?>></label></td>
    <?php
    echo "<td>" . $_SESSION['teachRow']['firstName'] . "</td>";
    echo "<td>" . $_SESSION['teachRow']['lastName'] . "</td>";
    echo "<td>" . $_SESSION['teachRow']['email'] . "</td>";
    echo "</tr>";
    $i++;
} while($_SESSION['teachRow'] = mysqli_fetch_array($result));
$_SESSION['i'] = $i;
?>
</table>
    <label><input id="teacherSaveButton" type="submit" value="Veranderingen opslaan"></label>
    </form>
</div>
    <?php if (isset($_SESSION['saved'])){echo "<h3 class='saved'> " . $_SESSION['saved'] . " </h3>";} unset($_SESSION['saved'])?>
</body>
</html>