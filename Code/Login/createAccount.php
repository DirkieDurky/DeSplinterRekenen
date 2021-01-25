<?php
session_start();
?>
<html lang="en">
<head>
    <title>Account maken</title>
    <link href="../style.php" rel=stylesheet>
</head>
<body id="signIn">
<div>
    <form action="signIn.php">
        <input class="backbutton" type="submit" value="Terug">
    </form>
</div>
<div class="field <?php if (isset($_SESSION['error'])&&$_SESSION['error']!=""){echo "extend";}?>" id=createAccount >
    <h1 class="title">Account aanmaken</h1>
    <form action="createAccountBackend.php">
        <label>
        Voornaam:<br>
        <input placeholder="Voornaam" type="text" name="firstname" value="<?php if (isset($_SESSION['creAccFirst'])) {echo $_SESSION['creAccFirst'];}?>"><br>
        </label>
        <label>
        Achternaam:<br>
        <input placeholder="Achternaam" type="text" name="lastname" value="<?php if (isset($_SESSION['creAccLast'])) {echo $_SESSION['creAccLast'];}?>"><br>
        <label>
        Email:<br>
        <input placeholder="Email" type="text" name="email" value="<?php if (isset($_SESSION['creAccEmail'])) {echo $_SESSION['creAccEmail'];}?>"><br>
        </label>
        <label>
        Wachtwoord:<br>
        <input placeholder="Wachtwoord" type="password" name="pass" value="<?php if (isset($_SESSION['creAccPass'])) {echo $_SESSION['creAccPass'];}?>"><br>
        </label>
        <label>
        Herhaal wachtwoord:<br>
        <input placeholder="Herhaal wachtwoord" type="password" name="repass" value="<?php if (isset($_SESSION['creAccRepass'])) {echo $_SESSION['creAccRepass'];}?>"><br>
        </label>
        <label class="teacher">
            Ik ben een leerling
            <input type="radio" name="teacher" value=0>
        </label>
        <label class="teacher">
            Ik ben een leraar
            <input type="radio" name="teacher" value=1>
        </label>
        <input class="submit" type="submit" value="Account aanmaken">
    </form>
    <h4 class="error" id="createAccount"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>