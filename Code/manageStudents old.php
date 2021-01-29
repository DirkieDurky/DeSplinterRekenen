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
    $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM `groups` WHERE id != 1");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
        <form action="deleteGroup.php">
        <table class="table" id="groups">
            <tr>
                <th></th>
                <th>Naam</th>
                <th>Aantal leerlingen in groep</th>
            </tr>
            <?php
            $i = 0;
            do {
                echo "<tr class='collapsible'>";
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
        </table>
        </form>
    <?php }
    if (isset($_GET['createGroup'])):
    ?>
    <form action="addGroup.php">
        <label>
            <input type="text" name="groupName" placeholder="Groepsnaam" autofocus>
        </label>
        <input type="submit" value="->" name="submit">
        <input type="submit" value="x">
    </form><br>
    <?php endif ?>
        <button class="addGroupButton" onclick="window.location.href='teacherSite.php?selected=1&createGroup=1';">Groep aanmaken</button>
    <?php
            $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE teacher=0");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row == ""){
        echo "<h3 class=table>Er zijn geen leerlingen om aan groepen toe te voegen.</h3>";
            } else {
    ?>
    <form action="addToGroup.php">
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
                <td><label>select<?php echo $row['id']?><input type="checkbox" name="select<?php echo $row['id']?>"></label></td>
                <?php
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            } while($row = mysqli_fetch_array($result));
            ?>
        </table>
        <?php
        $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "SELECT * FROM `groups` WHERE id != 1");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        ?>
        <label>
            Voeg geselecteerde leerling(en) toe aan groep:
            <select name="groups">
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
<?php if (isset($_SESSION['notif'])){echo "<h3 class='notif'> " . $_SESSION['notif'] . " </h3>";} unset($_SESSION['notif'])?>
</body>
</html>