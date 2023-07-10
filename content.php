<?php

$type = '';
$desc = '';

if (isset($_GET['type'])) {
    if (isset($_GET['desc'])) $desc = $_GET['desc'];
    $type = $_GET['type'];
    $cat_id = get_cat_id_from_name($conn, $desc);
} else {
    $type = "home";
}

echo "<h1>{$desc}</h1>";
// echo '<span id="content"></span>';
if ($type == 'home') {
    //check for login
    if (isset($_SESSION['user_name'])) {
        include './home.php';
    } else {
        include "./login.php";
    }
} elseif ($type == 'category') {
    include './categories.php';
} elseif ($type == 'stats') {
    include './stats.php';
} elseif ($type == 'year') {
    include './years.php';
} elseif ($type == 'config') {
    include './config.php';
} elseif ($type == 'account') {
    include './account.php';
} elseif ($type == 'category-maker') {
    include './category-maker.php';
}





?>