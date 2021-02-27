<?php
require_once "../../DB_Connection.php";
session_start();

$_SESSION['editingAssign'] = $_GET['assign'];
$_SESSION['editingQuestion'] = $_GET['question'];

$sth = $pdo -> prepare("SELECT * FROM `assignments` WHERE id = ?");
$sth -> execute([$_GET['assign']]);
$row = $sth -> fetch();
?>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opdracht maken</title>
    <link rel="stylesheet" href="../../Css/style.css">
    <link rel="stylesheet" href="../../Css/assignments.css">
    <script type="text/javascript" src="../notifications.js"></script>
</head>
<body>
    <div class="sidebar">
        <div id="sidebarText">
            <h2 class="title">Opdracht maken</h2>
            <form action="changeAssignName.php">
                <label>
                    <input type="text" name="changeName" placeholder="opdrachtnaam" value="<?= $row['name']; ?>">
                </label>
                <input type="submit" name="submitName" value="->">
            </form>
        </div>
        <div>
            <button class="collapsible">Tekst</button>
            <div class="collapsibleContent">
                <form action="createText.php">
                    <label>
                        <?php
                        $sth2 = $pdo -> prepare("SELECT `text`,`media`,`sum`,`answer` FROM `questions` WHERE assignmentID = ? AND `order` = ?");
                        $sth2 -> execute([$_GET['assign'], $_GET['question']]);
                        $row = $sth2 -> fetch();
                        if (isset($row['text']) && $row['text'] != "") {
                    echo "Voer tekst in om de oude tekst mee te vervangen:";
                } else {
                    echo "Voeg tekst toe:";
                }
                    ?>
                        <textarea name="text" rows="5" cols="35" style="resize: none"></textarea>
                    </label>
                    <input type="submit" value="->">
                </form>
            </div>
        </div>
        <div>
            <button class="collapsible">Afbeelding</button>
            <div class="collapsibleContent">
                <?php
                if (isset($row['media']) && $row['media'] != "") {
                    echo "Selecteer een afbeelding om de oude afbeelding mee te vervangen:";
                } else {
                    echo "Selecteer een afbeelding om in te voegen:";
                }
                ?>
                <form action="uploadQuestionImage.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload" accept=".png,.jpg,.jpeg,.gif">
                    <input type="submit" value="Uploaden" name="submit">
                </form>
            </div>
        </div>
        <div>
            <span id="sidebarText" style="margin-top: 10px">Vragen:</span>
                <button class="collapsible">Meerkeuzevraag</button>
                <div class="collapsibleContent">
                    <form action="createMultipleChoice.php">
                        <label>
                            Voer hier de vraag in die hoort bij de meerkeuzevraag:
                            <input type="text" name="question"><br>
                        </label>
                        Voer hier de mogelijke opties in voor je meerkeuzevraag.<br>
                        Je hoeft niet elke optie in te vullen.<br>
                        Vink het juiste antwoord aan.<br>
                        <?php for($i = 0; $i < 6; $i++) {?>
                            <label>
                                <input type="checkbox" onclick="
                                    document.getElementById('answer<?=$i?>').disabled = !document.getElementById('answer<?=$i?>').disabled;
                                    document.getElementById('correct<?=$i?>').disabled = !document.getElementById('correct<?=$i?>').disabled;"
                                name="checkbox<?=$i?>">
                                <input disabled type="text" id="answer<?=$i?>" name="answer<?=$i?>">
                                <input disabled type="radio" id="correct<?=$i?>" name="correct<?=$i?>">
                            </label><br>
                            <?php } ?>
                        <input type="submit" value="->">
                    </form>
                </div>
            <button class="collapsible">Vraag</button>
            <div class="collapsibleContent">
                <form action="createAnswer.php">
                    <label>
                        Voer je vraag in:<br>
                        <input type="text" name="question"><br>
                    </label>
                    <label>
                        Voer je antwoord in:<br>
                        <input type="text" name="answer"><br>
                    </label>
                    <label>
                        Voer eventuele eenheden in om na het antwoord veld te laten zien (Zoals km/u):<br>
                        <input type="text" name="unit">
                    </label>
                    <input type="submit" value="->">
                </form>
            </div>
                <button class="collapsible">Som</button>
                <div class="collapsibleContent">
                    <form action="createSum.php">
                        <label>
                            Voer je som in:
                            <input type="text" name="sum">
                        </label>
                        <input type="submit" value="->">
                    </form>
                </div>
        </div>
        <script>
            const coll = document.getElementsByClassName("collapsible");
            for (let i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("collapsibleActive");
                    const content = this.nextElementSibling;
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
            <a class="backbutton" id="assignmentEditor" href="../teacherSite.php?selected=2"><-</a>
    </div>
    <div id="assignment">
<?php include "assignment.php"; ?>
    </div>
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