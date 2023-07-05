<?php
include_once('./db-connect.php');
include_once('./functions.php');


session_start();
// $_SESSION['user_name'] = 'ccatura';
// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>What's The Best?</title>
</head>
<body>

<div id="container">
    <div id="header"><?php include "./header.php"; ?></div>
    <div id="content"><?php include "./content.php"; ?></div>
    <div id="footer"><?php include "./footer.php"; ?></div>
</div>


    
</body>
</html>