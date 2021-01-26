<?php
session_start();
$conn = new mysqli("localhost", "root", "", "desplinterrekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM groups");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

for ($j = -1; $j < $_SESSION['i']; $j++, $row = mysqli_fetch_array($result)) {
    if (isset ($_GET['delete' . $j])){
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "DELETE FROM groups WHERE id = ? AND name != 'default'");
        mysqli_stmt_bind_param($stmt, "i", $row['id']);
        mysqli_stmt_execute($stmt);
    }
}
header("Location: teacherSite.php?selected=1");