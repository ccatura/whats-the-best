<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$genres_id = $_GET['genres_id'];
$user_name = $_SESSION['user_name'];
echo $genres_id . '<br>';

$genres_name = get_genre_name_from_id($conn, $genres_id);


if (is_admin($conn, $_SESSION['user_name'])) {
    $sql = "DELETE FROM `cat_genre`
    WHERE `genre_id` = $genres_id;";
    run_sql($conn, $sql);

    $sql = "DELETE FROM `answers`
    WHERE `genre_id` = $genres_id;";
    run_sql($conn, $sql);

$sql = "DELETE FROM `genres`
    WHERE `id` = $genres_id;";
    run_sql($conn, $sql);
}

$_SESSION['message'] = "Deleted genre: {$genres_name}.";

echo "{$sql}<br> name: {$genres_name}";

header("Location: ./?type=config&desc=Config");