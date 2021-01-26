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
    <h1 class="title">Leerlingen beheren</h1>
    Hier kun je groepen aanmaken om leerlingen in te stoppen, <br>
    en daaronder is het mogelijk om leerlingen toe te voegen aan deze groepen.
    <?php
    $conn = new mysqli("localhost", "root", "", "desplinterrekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM groups WHERE name != 'default'");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
        <table class="table" id="groups">
            <tr>
                <th></th>
                <th>Naam</th>
                <th>Aantal leerlingen in groep</th>
            </tr>
            <form action="deleteGroup.php">
            <?php
            $i = 0;
            do {
                echo "<tr>";
                ?>
                <td><label><input type="submit" value="" name="delete<?php echo $i;?>"></label></td>
                <?php
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['studentCount'] . "</td>";
                echo "</tr>";
                $i++;
            } while($row = mysqli_fetch_array($result));
            $_SESSION['i'] = $i;
            ?>
            </form>
        </table>
    <?php }
    if (isset($_GET['createGroup'])):
    ?>
    <form class="addGroup" action="addGroup.php">
        <label>
            <input type="text" name="groupName" placeholder="Groepsnaam" autofocus>
        </label>
        <input type="submit" value="->" name="submit">
        <input type="submit" value="x">
    </form><br>
    <?php endif ?>
        <button class="addGroupButton" onclick="window.location.href='teacherSite.php?selected=1&createGroup=1';">Groep aanmaken</button>
    <?php
    $teacher = 0;
            $conn = new mysqli("localhost", "root", "", "desplinterrekenen");
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE teacher=?");
            mysqli_stmt_bind_param($stmt, "i", $teacher);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            $j = 0;
            if ($row == ""){
        echo "<h3 class=table>Er zijn geen leerlingen om aan groepen toe te voegen.</h3>";
            } else {
    ?>
    <form>
        <table class="table" id="students">
            <tr>
                <th></th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
            </tr>
            <?php
             do {
                echo "<tr>";
                ?>
                <td><label><input type="checkbox" name="select<?php echo $j;?>"></label></td>
                <?php
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
                $j++;
            } while($row = mysqli_fetch_array($result));
            ?>
        </table>
        <?php
        $conn = new mysqli("localhost", "root", "", "desplinterrekenen");
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "SELECT * FROM groups");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        ?>
        <label>
            Voeg geselecteerde leerling(en) toe aan groep:
            <select>
                <option disabled selected>groep</option>
                <?php
                do {
                    $name = $row['name'];
                    echo "<option>$name</option>";
                } while ($row = mysqli_fetch_array($result))
                ?>
            </select>
        </label>
        <input type="submit" value="->" name="submit">
    </form>
    <?php } ?>
</div>
<?php if (isset($_SESSION['saved'])){echo "<h3 class='saved'> " . $_SESSION['saved'] . " </h3>";} unset($_SESSION['saved'])?>
</body>
</html>