<?php
session_start();
$_SESSION['count'] = 0;
if (isset($_COOKIE['loginEmail'])) {
    $conn = new mysqli("localhost", "root", "", "deSplinterRekenen");
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM `accounts` WHERE Email=?");
    mysqli_stmt_bind_param($stmt, "s", $_COOKIE['loginEmail']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['loggedID'] = $row['id'];
    if ($row['teacher'] == FALSE) {
        header("Location: ../Student/studentSite.php?selected=1");
    } else {
        header("Location: ../teacher/teacherSite.php?selected=1");
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
        <label>
            Onthoud mijn gevens
            <input type="checkbox" name="rememberMe">
        </label><br>
            <input class="submit" name="submit" type="submit" value="Inloggen"><br>
    </form>
    <a class="hyperlinks" href="createAccount.php">Ik heb nog geen account</a>
    <h4 class="error" id="signIn"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>