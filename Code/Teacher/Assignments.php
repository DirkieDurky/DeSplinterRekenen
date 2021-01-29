<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="teacherSite">
<div class="teacherField">
    <h1 class="title">Opdrachten toedienen</h1>
    Hier kun je opdrachten toedienen aan bepaalde leerlingen of klassen.
    <?php
    $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM `groups`");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
    <table class="table" id="groups">
        <tr>
            <th>Naam</th>
            <th>Aantal leerlingen in groep</th>
        </tr>
            <?php
            $i = 0;
            do {
                echo "<tr>";
                ?>
                <?php
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['studentCount'] . "</td>";
                echo "</tr>";
                $i++;
            } while($row = mysqli_fetch_array($result));
            }
            ?>
    </table>
</div>
</body>
</html>