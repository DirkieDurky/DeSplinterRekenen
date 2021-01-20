<?php
function OpenCon(){
    $conn = new mysqli("localhost", "root", "","desplinterrekenen") or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}

function CloseCon($conn){
    $conn -> close();
}