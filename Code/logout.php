<?php
setcookie("loginEmail","",time() - 3600);
header("Location: signIn.php");