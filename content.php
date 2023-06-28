<?php

$type = null;
$cat = null;

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $cat = $_GET['cat'];
} else {
    $type = "home";
}


echo "<div>" . $type . "</div>";
echo "<div>" . $cat . "</div><br><br><br>";






?>