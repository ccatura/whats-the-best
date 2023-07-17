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

$cat_name = get_cat_name_from_id($conn, $cat_id);
run_sql($conn, $sql);
$_SESSION['message'] = "Deleted category: {$cat_name}.";

echo "{$sql}<br> name: {$cat_name}";

header("Location: ./?type=config&desc=Config");