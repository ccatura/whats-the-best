<?php
include_once('./db-connect.php');
include_once('./functions.php');


session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <script src ='./scripts.js' defer></script>
    <title>What's The Best?</title>
</head>
<body>

<div id="container">
    <div id="header"><?php include "./header.php"; ?></div>
    <div id="content"><?php include "./content.php"; ?></div>
    <div id="footer"><?php include "./footer.php"; ?></div>
</div>

<div id="popup-blackout">
    <div id="popup-window">
        <div id="popup-header"><div id="popup-title"></div><div id="close">&#10005;</div></div>
        <div id="popup-message"></div>
        <div id="popup-buttons"><button id='popup-yes' class='sub button'>Yes</button><button id='popup-no' class='sub button'>No</button></div>
    </div>
</div>
    
</body>
</html>