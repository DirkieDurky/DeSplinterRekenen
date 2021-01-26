<?php
session_start();
$conn = new mysqli("localhost", "root", "", "desplinterrekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE teacher=1 AND id!=?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['loggedID']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

for ($j=0; $j<$_SESSION['i']; $j++, $row = mysqli_fetch_array($result)){
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "UPDATE accounts SET perms = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $_GET['perms' . $j], $row['id']);
    mysqli_stmt_execute($stmt);
    echo "Set the perms for user with id " . $row['id'] . " to " . $_GET['perms' . $j] . "<br>";
}
$_SESSION['saved'] = "Veranderingen zijn opgeslagen!";
header("Location: teacherSite.php?selected=0");