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

    <meta property="og:title" content="What's the Best? of the 70's, 80's, and 90's" />
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://meetmeinthe80s.com/apps/whats-the-best/images/other/whats-the-best-logo-vertical.jpg" />
    <meta property="og:url" content="https://meetmeinthe80s.com/apps/whats-the-best/" />
    <meta property="og:description" content="A social nostaglic website where users get to choose what is the best of the best from the 70's, 80's, and 90's!" />

    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="meetmeinthe80s.com">
    <meta property="twitter:url" content="https://meetmeinthe80s.com/apps/whats-the-best/">
    <meta name="twitter:title" content="What's The Best? of the 70's, 80's, and 90's">
    <meta name="twitter:description" content="A social nostaglic website where users get to choose what is the best of the best from the 70's, 80's, and 90's!">
    <meta name="twitter:image" content="https://meetmeinthe80s.com/apps/whats-the-best/images/other/whats-the-best-logo-vertical.jpg">

    <meta name="title" content="What's the Best?">
    <meta name="description" content="A social nostaglic website where users get to choose what is the best of the best from the 70's, 80's, and 90's!">
    <meta name="keywords" content="70s, 80s, 90s, 70's, 80's, 90's, nostalgia, retro, genx, gen-x">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">

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