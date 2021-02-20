<?php
require_once("../DB_Connection.php");
session_start();
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
    <?php

    $_SESSION['editingAssign'] = $_GET['assign'];

    $sth = $pdo -> prepare("SELECT * FROM `assignments`");
    $sth -> execute();
    $row = $sth -> fetch();

    if (isset($row['id'])) {
        $sth2 = $pdo->prepare("SELECT * FROM `exercises` WHERE 'assignment'=?;");
        $sth2->execute([$row['id']]);
        $row2 = $sth2->fetch();
    }

    $i = 1;
    while ($row = $sth2 -> fetch()) {
        $sth3 = $pdo -> prepare("SELECT * FROM `exercises` WHERE 'assignment'=? AND 'order'=?;");
        $sth3 -> execute([$row['id'],$i]);
        $row3 = $sth3 -> fetch();
        if (isset($row3['content'])){
            echo $row3['content'];
        }
        $i++;
    }

    $sth = $pdo -> prepare("SELECT * FROM `assignments` WHERE id = ?");
    $sth -> execute([$_GET['assign']]);
    $row = $sth -> fetch();
    ?>
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
            <button class="collapsible">Titel</button>
            <div class="collapsibleContent">
                <p>Test</p>
            </div>
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
    </div>
</body>
</html>