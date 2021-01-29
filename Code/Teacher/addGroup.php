<?php
if (isset($_GET['submit'])) {
    $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "INSERT INTO `groups` (name, studentCount) VALUE (?, 0)");
    mysqli_stmt_bind_param($stmt, "s", $_GET['groupName']);
    mysqli_stmt_execute($stmt);
}
header("Location: teacherSite.php?selected=1");