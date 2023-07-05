<?php
include_once('./db-connect.php');
include_once('./functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <script src="./scripts.js" defer></script>
    <title>CONFIG - What's The Best?</title>
</head>
<body>

<div id="container">

<?php

get_config($conn);







?>

</div>


    
</body>
</html>