<?php
$sth = $pdo -> prepare("SELECT * FROM `questions` WHERE assignmentID = ? AND `order` = ?");
$sth -> execute([$_SESSION['activeAssign'],$_SESSION['activeQuestion']]);
$row = $sth -> fetch();
?>
<html lang="nl">
<head>
    <title>Css shit</title>
</head>
<body>
    <style>
        .element {
            left: <?php if (isset($row['media']) && $row['media'] != ""){ echo "55";} else {echo "25";} ?>%;
        }
    </style>
</body>
</html>