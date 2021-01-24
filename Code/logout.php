<?php
setcookie("loginEmail","",time() - 3600,"/");
header("Location: Login/signIn.php");