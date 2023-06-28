<?php
    $servername = "sql647.main-hosting.eu";
    $username = "u682819236_ccatura_whats";
    include("pword.php");
    $dbname = "u682819236_whats_the_best";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
    if(!$conn){
        die('Could not Connect MySql Server:' .mysql_error());
    }
?>