<?php
require_once "../../DB_Connection.php";
session_start();

$sth1 = $pdo->prepare("SELECT name FROM `assignments` WHERE id = ?");
$sth1->execute([$_SESSION['editingAssign']]);
$row1 = $sth1->fetch();

$sth2 = $pdo->prepare("SELECT * FROM `groups` WHERE id != ?");
$sth2->execute([1]);
$row2 = $sth2->fetch();
?>
<html lang="nl">
<head>
    <title>Opdracht toedienen</title>
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/assignments.css">
</head>
<body style="background-color: #181818;">

<div id="assignField">
    <h1 id="assignAssignmentTitle">Opdracht "<?= $row1['name'] ?>" toedienen:</h1>
    <?php
    if ($row2 == ""){
        echo "<h3 class=table>Er zijn nog geen groepen aangemaakt.</h3>";
    } else {
    ?>
    <?php do { ?>
        <table class="collapsible">
            <tr>
                <th>
                    <label class="groupDelete"><input type="checkbox" value="" name="deleteGroup<?php echo $row2['id'];?>"></label>
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
                                ?>
                                <tr>
                                <td><label><input type="checkbox" value="" name="deleteUser<?php echo $row3['id'];?>"></label></td>
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
    <?php } while($row2 = $sth2 -> fetch());

    $sth4 = $pdo -> prepare("SELECT * FROM `accounts` WHERE teacher=0 AND groupID=1");
    $sth4 -> execute();
    $row4 = $sth4 -> fetch();
    ?>
    <h3 id="subTitle">Leerlingen die niet in een groep zitten:</h3>
    <form action="assignAssignment.php">
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
                <td><label><input type="checkbox" name="select<?php echo $row4['id'] ?>"></label></td>
                <?php
                echo "<td>" . $row4['firstName'] . "</td>";
                echo "<td>" . $row4['lastName'] . "</td>";
                echo "<td>" . $row4['email'] . "</td>";
                echo "</tr>";
            } while ($row4 = $sth4->fetch());
            ?>
        </table>
        <?php } ?>
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
   href="<?= "assignmentEditor.php?assign=" . $_SESSION['editingAssign'] . "&question=" . $_SESSION['editingQuestion'] ?>"><-</a>
</body>
</html>
