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
    <h1>Leerlingen beheren</h1>
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
        <form action="deleteGroup.php" id="groups">
            <?php do { ?>
        <table class="collapsible">
            <tr>
                <th>
                    <label class="groupDelete"><input type="submit" value="" name="deleteGroup<?php echo $row['id'];?>"></label>
                    <?php echo $row['name'] ?>
                </th>
            </tr>
            <tr>
                <td class="collapsibleContent" id="table">
                <?php
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE groupID = ?");
                mysqli_stmt_bind_param($stmt, "s", $row['id']);
                mysqli_stmt_execute($stmt);
                $result2 = mysqli_stmt_get_result($stmt);
                $row2 = mysqli_fetch_assoc($result2);
                if (isset($row2['firstName'])){
                    ?>
                    <table class="table" id="usersInGroup">
                    <tr>
                        <th>
                        </th>
                        <th>
                            Voornaam
                        </th>
                        <th>
                            Achternaam
                        </th>
                        <th>
                            Email
                        </th>
                    </tr>
                    <?php
                    do {
                        ?>
                        <tr>
                        <td><label><input type="submit" value="" name="deleteUser<?php echo $row2['id'];?>"></label></td>
                            <?php
                    echo "<td>" . $row2['firstName'] . "</td>";
                    echo "<td>" . $row2['lastName'] . "</td>";
                    echo "<td>" . $row2['email'] . "</td>";
                            ?></tr><?php
                    } while($row2 = mysqli_fetch_array($result2));
                    ?>
                    </table>
                    <?php
                } else {
                    echo "Deze groep is leeg.";
                }
                ?>
                </td>
            </tr>
        </table>
            <?php } while($row = mysqli_fetch_array($result)); ?>
        </form>

        <script>
            var collapsible = document.getElementsByClassName("collapsible");
            for (var i = 0; i < collapsible.length; i++) {
                collapsible[i].addEventListener("click", function(e) {
                    if (e.target.tagName.toLowerCase() === 'input') {
                        return;
                    }
                    this.classList.toggle("collapsibleActive");
                    var content = this.querySelector('.collapsibleContent');
                    if (content.style.maxHeight){
                        content.style.maxHeight = null;
                        setTimeout(function(){
                            content.style.display = "none";
                        }, 200)
                    } else {
                        content.style.display = "block";
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            }
        </script>
    <?php }
    if (isset($_GET['createGroup'])):
    ?>
    <form action="addGroup.php" id="addGroupForm">
        <label>
            <input type="text" name="groupName" placeholder="Groepsnaam" autofocus>
        </label>
        <input type="submit" value="->" name="submit">
        <input type="submit" value="x">
    </form><br>
    <?php endif ?>
        <button id="addGroupButton" onclick="window.location.href='teacherSite.php?selected=1&createGroup=1';">Groep aanmaken</button>
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
                <td><label><input type="checkbox" name="select<?php echo $row['id']?>"></label></td>
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
        <div id="addToGroupForm">
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
        </div>
    </form>
    <?php } ?>
</div>
<?php if (isset($_SESSION['notif'])){echo "<h3 class='notif'> " . $_SESSION['notif'] . " </h3>";} unset($_SESSION['notif'])?>
</body>
</html>