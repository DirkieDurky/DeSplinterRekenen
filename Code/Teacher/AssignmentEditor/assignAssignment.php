<?php
require_once "../../DB_Connection.php";
session_start();

$sth1 = $pdo->prepare("SELECT name FROM `assignments` WHERE id = ?");
$sth1->execute([$_SESSION['activeAssign']]);
$row1 = $sth1->fetch();

$sth2 = $pdo->prepare("SELECT * FROM `groups` WHERE id != 1");
$sth2->execute();
$row2 = $sth2->fetch();
?>
<html lang="nl">
<head>
    <title>Opdracht toedienen</title>
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/assignments.css">
    <script type="text/javascript" src="../notifications.js"></script>
</head>
<body style="background-color: #181818;">
    <script>
        const groupSelect = document.getElementById("groupSelect");
        const childChkBoxs = document.getElementsByClassName("childChkBoxs");
    </script>

<div id="assignField">
    <h1 id="assignAssignmentTitle">Opdracht "<?= $row1['name'] ?>" toedienen:</h1>
    <?php
    if ($row2 == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
    <form action="assignAssignmentBackend.php">
    <?php do {
        $resultExistsOfPeopleAmount = 0;
        $sth12 = $pdo -> prepare("SELECT id FROM `accounts` WHERE groupID = ?");
        $sth12 -> execute([$row2['id']]);
        $row12 = $sth12 -> fetch();

        do {
            $sth13 = $pdo -> prepare("SELECT id FROM `results` WHERE assignmentID= ? AND studentID = ?");
            $sth13 -> execute([$_SESSION['activeAssign'], $row12['id']]);
            $row13 = $sth13 -> fetch();

            if ($sth13 -> rowCount() > 0) {
                $resultExistsOfPeopleAmount++;
            }
        } while ($row12 = $sth12 -> fetch());

        ?>
        <table class="collapsible">
            <tr>
                <th>
                    <label class="groupDelete"><input onclick="
                    if (this.checked) {
                        for (let i = 0; i < childChkBoxs.length; i++) {
                            childChkBoxs[i].checked = true;
                        }
                    } else {
                        for (let i = 0; i < childChkBoxs.length; i++) {
                            childChkBoxs[i].checked = false;
                        }
                    }
                    " type="checkbox" value="" name="selectGroup<?php echo $row2['id'];?>" id="groupSelect"
                            <?php if ($sth12 -> rowCount() == $resultExistsOfPeopleAmount){ echo "checked";} ?>
                        ></label>
                    <?php echo $row2['name'] ?>
                </th>
            </tr>
            <tr>
                <td class="collapsibleContent" id="table">
                    <?php
                    $sth3 = $pdo -> prepare("SELECT * FROM `accounts` WHERE groupID = ?");
                    $sth3 -> execute([$row2['id']]);
                    $row3 = $sth3 -> fetch();
                    if (isset($row3['firstName'])){
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
                                $sth10 = $pdo -> prepare("SELECT id FROM `results` WHERE assignmentID= ? AND studentID = ?");
                                $sth10 -> execute([$_SESSION['activeAssign'], $row3['id']]);
                                $row10 = $sth10 -> fetch();
                                ?>
                                <tr>
                                <td><label><input onclick="
                                let checkedAmount = 0;
                                for (let i = 0; i < childChkBoxs.length; i++) {
                                        if (childChkBoxs[i].checked === true) {
                                            checkedAmount++;
                                        }
                                    }
                                groupSelect.checked = checkedAmount === childChkBoxs.length;
                                console.log(checkedAmount);
                                console.log(childChkBoxs.length);
                                " class="childChkBoxs" type="checkbox" value="" name="selectInGroup<?php echo $row3['id'];?>" <?php if ($sth10 -> rowCount() > 0){echo "checked";} ?>></label></td>
                                <?php
                                echo "<td>" . $row3['firstName'] . "</td>";
                                echo "<td>" . $row3['lastName'] . "</td>";
                                echo "<td>" . $row3['email'] . "</td>";
                                ?></tr><?php
                            } while($row3 = $sth3 -> fetch());
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
    <?php } while($row2 = $sth2 -> fetch()); ?>

    <?php
    $sth4 = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0 AND groupID=1");
    $sth4 -> execute();
    $row4 = $sth4 -> fetch();
    ?>
    <h3 id="subTitle">Leerlingen die niet in een groep zitten:</h3>
        <table class="table" id="students">
            <tr>
                <th></th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
            </tr>
            <?php
            do {
                $sth5 = $pdo -> prepare("SELECT id FROM `results` WHERE assignmentID= ? AND studentID = ?");
                $sth5 -> execute([$_SESSION['activeAssign'], $row4['id']]);
                $row5 = $sth5 -> fetch();
                echo "<tr>";
                ?>
                <td><label><input type="checkbox" name="selectNotInGroup<?php echo $row4['id'] ?>" <?php if ($sth5 -> rowCount() > 0){echo "checked";} ?>></label></td>
                <?php
                echo "<td>" . $row4['firstName'] . "</td>";
                echo "<td>" . $row4['lastName'] . "</td>";
                echo "<td>" . $row4['email'] . "</td>";
                echo "</tr>";
            } while ($row4 = $sth4->fetch());
            ?>
        </table>
        <?php } ?>
        <input type="submit" value="Verzenden" name="submit">
    </form>
        <script>
            const collapsible = document.getElementsByClassName("collapsible");
            for (let i = 0; i < collapsible.length; i++) {
                collapsible[i].addEventListener("click", function(e) {
                    if (e.target.tagName.toLowerCase() === 'input') {
                        return;
                    }
                    this.classList.toggle("collapsibleActive");
                    const content = this.querySelector('.collapsibleContent');
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
</div>
<a class="backbutton" id="assignmentEditor"
   href="<?= "assignmentEditor.php?assign=" . $_SESSION['activeAssign'] . "&question=" . $_SESSION['activeQuestion'] ?>"><-</a>
<?php
if (isset($_SESSION['notification'])) {
    echo "<h3 class='notification' id='notification'> " . $_SESSION['notification'] . " </h3>";
    unset($_SESSION['notification']); ?>
    <script> notifications('notification') </script>
<?php }

if (isset($_SESSION['error'])) {
    echo "<h3 class='notification' id='error'> " . $_SESSION['error'] . " </h3>";
    unset($_SESSION['error']); ?>
    <script> errors('error') </script>
<?php } ?>
</body>
</html>
