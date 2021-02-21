<?php
require_once "../DB_Connection.php";
session_start();

$_SESSION['editingAssign'] = $_GET['assign'];

$sth = $pdo -> prepare("SELECT * FROM `assignments` WHERE id = ?");
$sth -> execute([$_GET['assign']]);
$row = $sth -> fetch();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Opdracht maken</title>
    <link rel="stylesheet" href="../style.php">
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
                <p>Test</p>
            </div>
        </div>
        <div>
            <button class="collapsible">Afbeelding</button>
            <div class="collapsibleContent">
                <p>Test</p>
            </div>
        </div>
        <div>
            <button class="collapsible">Video</button>
            <div class="collapsibleContent">
                <p>Test</p>
            </div>
        </div>
        <div>
            <button class="collapsible">Meerkeuzevraag</button>
            <div class="collapsibleContent">
                <p>Test</p>
            </div>
        </div>
        <div>
            <button class="collapsible">Som</button>
            <div class="collapsibleContent">
                <p>Test</p>
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
            <a class="backbutton" id="assignmentEditor" href="teacherSite.php?selected=2"><-</a>
    </div>
    <div id="assignment">
<?php include "assignment.php"; ?>
    </div>
</body>
</html>