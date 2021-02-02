<?php
$conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts`");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

for ($j = -1; $j < $row['id']; $j++, $row = mysqli_fetch_array($result)) {
    if (isset ($_GET['deleteUser' . $row['id']])){
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "UPDATE `accounts` SET groupID = 1 WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $row['id']);
        mysqli_stmt_execute($stmt);
        echo "tried to delete user " . $row['id'];
    }
    echo "user " . $row['id'] . " not deleted";
}
//header("Location: teacherSite.php?selected=1");