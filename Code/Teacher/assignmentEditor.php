<?php
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
    require_once ("../DBConnection.php");

    $sth = $pdo -> prepare("SELECT * FROM `assignments`");
    $sth -> execute();
    $row = $sth -> fetch();

    if (isset($row['id'])) {
        $sth = $pdo->prepare("SELECT * FROM `exercises` WHERE 'assignment'=?;");
        $sth->execute([$row['id']]);
        $row = $sth->fetch();
    }

    $i = 1;
    while ($row = $sth -> fetch()) {
        $sth = $pdo -> prepare("SELECT * FROM `exercises` WHERE 'assignment'=? AND 'order'=?;");
        $sth -> execute([$row['id'],$i]);
        $row = $sth -> fetch();
        if (isset($row['content'])){
            echo $row['content'];
        }
        $i++;
    }
    ?>
    <div class="sidebar">
        <center><h2 class="title">Opdracht maken</h2>
        <form>
            <label>
                <input type="text" name="changeName" placeholder="opdrachtnaam">
            </label>
            <input type="submit" name="submitName" value="->">
        </form>
        </center>
        <?php

        ?>
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
            var coll = document.getElementsByClassName("collapsible");
            for (var i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("collapsibleActive");
                    var content = this.nextElementSibling;
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