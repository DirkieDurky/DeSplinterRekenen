<?php
session_start();
$_SESSION['conn'] = new mysqli("localhost", "root", "","desplinterrekenen");
