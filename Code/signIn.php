<?php
session_start();
if (isset($_COOKIE['userEmail'])){
    header("signInBackend.php");
}
?>
<html lang="nl">
<head>
    <title>Inloggen</title>
    <link href=css.php rel=stylesheet>
</head>
<body>
<div class="field <?php if (isset($_SESSION['error']) && $_SESSION['error']!=""){echo "extend";}?>" id="signIn">
    <h1 class=title>Inloggen bij de Splinter Rekensite</h1><br>
    <form action="signInBackend.php">
        <div class=name>
            <label>
                Email:<br>
                <input class="input" name=email placeholder=Email type=text value="<?php if (isset($_SESSION['signInEmail'])) {echo $_SESSION['signInEmail'];}?>">
            </label><br>
        </div>
        <div class=pass>
            <label>
            Wachtwoord:<br>
            <input class="input" name=pass placeholder=Wachtwoord type=password value="<?php if (isset($_SESSION['signInPass'])) {echo $_SESSION['signInPass'];}?>">
            </label><br>
        </div>
        <div>
            <input class="submit" name="submit" type="submit" value="Inloggen">
        </div>
        <div class="signInLinks">
            <a class="hyperlinks" href="createAccount.php">Ik heb nog geen account</a>
        </div>
    </form>
    <h4 class="error" id="signIn"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>