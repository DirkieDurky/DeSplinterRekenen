<?php
session_start();
$_SESSION['appMan'] = FALSE;
if (isset($_COOKIE['loginEmail'])){
$_SESSION['conn'] = new mysqli("localhost", "root", "","desplinterrekenen");
$stmt = mysqli_stmt_init($_SESSION['conn']);
mysqli_stmt_prepare($stmt, "SELECT * FROM accounts WHERE Email=?");
mysqli_stmt_bind_param($stmt, "s", $_COOKIE['loginEmail']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

    if ($row['Type'] == 0) {
        header("Location: ../Student/studentSite.php?selected=1");
    } elseif ($row['Type'] == 1){
        header("Location: ../Teacher/teacherSite.php?selected=1");
    } else {
        $_SESSION['appMan'] = TRUE;
        header("Location: ../Teacher/teacherSite.php?selected=0");
    }
}
?>
<html lang="nl">
<head>
    <title>Inloggen</title>
    <link href=../style.php rel=stylesheet>
</head>
<body id="signIn">
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
        <div>
            <a class="hyperlinks" href="createAccount.php">Ik heb nog geen account</a>
        </div>
    </form>
    <h4 class="error" id="signIn"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>