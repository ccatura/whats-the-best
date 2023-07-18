<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$genres_id = $_GET['genres_id'];
$user_name = $_SESSION['user_name'];
echo $genres_id;

// IMPORTANT - NOT SURE IF THIS APPLIES TO GENRES YET, BUT LOOK INTO IT
// before deleting genre, need to delete cat_genre entries
// THEY ARE FORIGN KEY CONSTRAINTS
if ($user_name == 'ccatura') {
    $sql = "DELETE FROM `genres`
    WHERE `id` = $genres_id;";
}

$genres_name = get_genre_name_from_id($conn, $genres_id);
run_sql($conn, $sql);
$_SESSION['message'] = "Deleted genre: {$genres_name}.";

echo "{$sql}<br> name: {$genres_name}";

header("Location: ./?type=config&desc=Config");