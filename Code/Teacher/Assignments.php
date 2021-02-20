<?php
session_start();
require_once("../DB_Connection.php");
?>
<html lang="nl">
<head>
    <title>Leraren site</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="teacherSite">
<div class="teacherField">
    <h1>Opdrachten toedienen</h1>
    Hier kun je opdrachten toedienen aan bepaalde leerlingen of klassen.
    <?php
    $sth = $pdo -> prepare("SELECT * FROM `groups` WHERE id != 1");
    $sth -> execute();
    $row = $sth -> fetch();
    if ($row == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
        <form action="deleteGroup.php" id="groups">
            <?php do { ?>
        <table class="collapsible">
            <tr>
                <th>
                    <label class="groupDelete"><input type="checkbox" value="" name="deleteGroup<?php echo $row['id'];?>"></label>
                    <?php echo $row['name'] ?>
                </th>
            </tr>
            <tr>
                <td class="collapsibleContent" id="table">
                <?php
                $sth2 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID = ?");
                $sth2 -> execute([$row['id']]);
                $row2 = $sth2 -> fetch();
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
                        <td><label><input type="checkbox" value="" name="deleteUser<?php echo $row2['id'];?>"></label></td>
                            <?php
                    echo "<td>" . $row2['firstName'] . "</td>";
                    echo "<td>" . $row2['lastName'] . "</td>";
                    echo "<td>" . $row2['email'] . "</td>";
                            ?></tr><?php
                    } while($row2 = $sth2 -> fetch());
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
            <?php } while($row = $sth -> fetch()); ?>
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
    $sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0 AND groupID=1");
    $sth -> execute();
    $row = $sth -> fetch();
    if (!$row == "") {
        ?>
            <h3>Leerlingen die niet in een groep zitten:</h3>
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
                } while($row = $sth -> fetch());
                ?>
            </table>
            <?php }
            $sth = $pdo -> prepare("SELECT * FROM `assignments`");
            $sth -> execute();
            $row = $sth -> fetch();
            ?>
            <div id="addToGroupForm">
                <label>
                    Dien de geselecteerde leerlingen en groepen de volgende opdracht toe:
                    <select name="assignments">
                        <option disabled selected>opdracht</option>
                        <?php
                        do {
                            $name = $row['name'];
                            echo "<option>$name</option>";
                        } while ($row = $sth -> fetch())
                        ?>
                    </select>
                </label>
                <input type="submit" value="->" name="submit">
            </div>
        </form>
    <h1>Opdrachten bewerken of maken</h1>
    <?php
    if (!$row == ""){
    ?>
    <form action="deleteAssignment.php">
    <?php do { ?>
        <div>
            <button id="editAssignButtons" onclick="window.location.href = 'assignmentEditor.php?assign=<?= $row['id']?>';">
                <label id="buttonDelete"><input type="button" name="delete<?= $row['id']; ?>"></label>
                <?= $row['name']?>
                <span id="continueIcon">-></span></button>
        </div>
    <?php } while($row = $sth -> fetch());?>
        </form>
    <?php } ?>
    <form action="createAssignment.php" id="createAssignForm">
        <input type="hidden" name="selected" value="2">
        <label>
            Maak een nieuwe opdracht met de naam
            <input type="text" name="assignmentName" placeholder="naam">
        </label>
        <input type="submit" name="createAssignButton" value="->">
    </form>
    <h4 class="error" id="assignments"><?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>