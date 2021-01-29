<?php
$conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE teacher=0");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM `groups` WHERE name = ?");
mysqli_stmt_bind_param($stmt, "s", $_GET['groups']);
mysqli_stmt_execute($stmt);
$result2 = mysqli_stmt_get_result($stmt);
$row2 = mysqli_fetch_assoc($result2);

echo "There were " . mysqli_num_rows($result) . " boxes to be checked<br>";

for ($i=0; $i<mysqli_num_rows($result); $i++, $row = mysqli_fetch_array($result)) {
    if (isset($_GET['select' . $row['id']])) {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "UPDATE `accounts` SET groups = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $row2['id'], $row['id']);
        mysqli_stmt_execute($stmt);
    } else {
        echo "select" . $row['id'] . " was not checked<br>";
    }
}
header("Location: teacherSite.php?selected=1");