<?php
$conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM `groups`");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$groups = mysqli_fetch_assoc($result);

$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE groupID != 1");
mysqli_stmt_execute($stmt);
$result2 = mysqli_stmt_get_result($stmt);
$usersInGroup = mysqli_fetch_assoc($result2);

for ($j = -1; $j < $groups['id'] || $j < $usersInGroup['id']; $j++, $groups = mysqli_fetch_array($result), $usersInGroup = mysqli_fetch_array($result2)) {
    //Remove group if asked
    if (isset ($_GET['deleteGroup' . $groups['id']])) {
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE groupID = ?");
        mysqli_stmt_bind_param($stmt, "s", $groups['id']);
        mysqli_stmt_execute($stmt);
        $result3 = mysqli_stmt_get_result($stmt);
        $inThisGroup = mysqli_fetch_assoc($result3);

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "UPDATE `accounts` SET groups = 1 WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $inThisGroup['id']);
        mysqli_stmt_execute($stmt);

        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "DELETE FROM groups WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $groups['id']);
        mysqli_stmt_execute($stmt);
    }
    //Remove user from group if asked
    if (isset ($_GET['deleteUser' . $usersInGroup['id']])){
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "UPDATE `accounts` SET groupID = 1 WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $usersInGroup['id']);
        mysqli_stmt_execute($stmt);
        echo "user " . $usersInGroup['id'] . " deleted from group.<br>";
        }
    echo "user " . $usersInGroup['id'] . " not deleted from group.<br>";
    }
header("Location: teacherSite.php?selected=1");