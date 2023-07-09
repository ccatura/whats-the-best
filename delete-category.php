<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$cat_id = $_GET['cat_id'];
$user_name = $_SESSION['user_name'];

// IMPORTANT
// before deleting cetgory, need to delete cat_genre entries
// THEY ARE FORIGN KEY CONSTRAINTS
if ($user_name == 'ccatura') {
    $sql = "DELETE FROM `categories`
    WHERE `id` = $cat_id;";
}

run_sql($conn, $sql);

echo $sql . '<br>';

header("Location: ./?type=config&desc=Config");