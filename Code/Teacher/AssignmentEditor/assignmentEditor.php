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
    <link rel="stylesheet" href="../../style.php">
</head>
<body>
    <div class="sidebar">
        <div id="headOfSidebar">
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
                <form action="addTextToQuestion.php">
                    <label>
                        <?php
                        $sth2 = $pdo -> prepare("SELECT `text`,`media`,`question`,`options`,`answer` FROM `questions` WHERE assignmentID = ? AND `order` = ?");
                        $sth2 -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
                        $row = $sth2 -> fetch();
                        if (isset($row['text']) && $row['text'] != "") {
                            echo "Oude tekst verwijderen?";
                        ?> <a id="deleteElements" href="deleteQuestionText.php">x</a><br> <?php
                    echo "Of voer tekst in om de oude tekst mee te vervangen:";
                } else {
                    echo "Voeg tekst toe:";
                }
                    ?>
                    <input type="text" name="text">
                    </label>
                    <input type="submit" value="->">
                </form>
            </div>
        </div>
        <div>
            <button class="collapsible">Afbeelding</button>
            <div class="collapsibleContent">
                <?php
                //Remove number from file

                //Get the file location
                $sth2 = $pdo -> prepare("SELECT `media` from `questions` WHERE assignmentID = ? AND `order` = ?");
                $sth2 -> execute([$_SESSION['editingAssign'], $_SESSION['editingQuestion']]);
                $row = $sth2 -> fetch();

                //Remove directory
                $slashLocation = strrpos($row['media'], "/");
                $fullFileName = substr($row['media'], $slashLocation+1);

                //Remove number from file
                $underscoreLocation = strrpos($fullFileName, "_");

                $fileName = substr($fullFileName, $underscoreLocation+1);

                if (isset($row['media']) && $row['media'] != "") {
                    echo "Oude afbeelding \"$fileName\" verwijderen?";
                    ?> <a href="deleteQuestionImage.php" id="elementDelete">x</a><br> <?php
                    echo "Of selecteer een afbeelding om de oude afbeelding mee te vervangen:";
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
            <button class="collapsible">Vraag</button>
            <div class="collapsibleContent">
                <p>Meerkeuzevraag</p>
                <p>Som</p>
                <p>Antwoordveld</p>
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
    <?php if (isset($_SESSION['notification'])){echo "<h3 class='notification'> " . $_SESSION['notification'] . " </h3>";} unset($_SESSION['notification'])?>
    <?php if (isset($_SESSION['error'])){echo "<h3 class='notification' id='error'> " . $_SESSION['error'] . " </h3>";} unset($_SESSION['error'])?>
</body>
</html>