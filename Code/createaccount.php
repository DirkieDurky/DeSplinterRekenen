<html>
<head>
    <title>Account maken</title>
    <link href="css.php" rel=stylesheet>
</head>
<body>
<div class="field <?php session_start(); if (isset($_SESSION['error'])&&$_SESSION['error']!=""){echo "extend";}?>" id=createaccount >
    <h1 class="title">Account aanmaken</h1>
    <h4 class="undertitle">Als je een leraar bent kun je hier je account aanmaken.
        Als je een leerling bent moet een leraar je account maken.</h4>
    <form action="addAccToDB.php">
        Voornaam:<br>
        <input class="input" placeholder="Voornaam" type="text" name="firstname"><br>
        Achternaam:<br>
        <input class="input" placeholder="Achternaam" type="text" name="lastname"><br>
        Email:<br>
        <input class="input" placeholder="Email" type="text" name="email"><br>
        Wachtwoord:<br>
        <input class="input" placeholder="Wachtwoord" type="password" name="pass"><br>
        Herhaal wachtwoord:<br>
        <input class="input" placeholder="Herhaal wachtwoord" type="password" name="repass"><br>
        <input class="submit" type="submit" value="Account aanmaken">
    </form>
    <h4 class="error"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>