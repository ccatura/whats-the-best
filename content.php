<?php

$type = '';
$desc = '';

if (isset($_GET['type'])) {
    if (isset($_GET['desc'])) $desc = $_GET['desc'];
    $type = $_GET['type'];
    $cat_id = get_cat_id_from_name($conn, $desc);
} else {
    $type = "home";
    $desc = "What's the Best?";
}

echo "<h1>{$desc}</h1>";
include "./{$type}.php";







?>