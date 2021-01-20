<?php
mail($_GET['email'],"Wachtwoord resetten","Jij of iemand die je als jou voor 
doet heeft een wachtwoordreset aangevraagd op jouw DeSplinterRekenen account.");
echo "Email verzonden! We sturen je door naar een pagina om je wachtwoord te resetten...";
header("forgotpass2.html");