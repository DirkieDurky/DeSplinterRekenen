<?php
session_start();
$_SESSION['conn'] = new mysqli("localhost", "root", "","desplinterrekenen") or die("Connect failed: %s\n". $conn -> error);
