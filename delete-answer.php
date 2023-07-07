<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$data_id = $_GET['data_id'];
$categories_id = $_GET['categories_id'];
$genres_id = $_GET['genres_id'];
$user_name = $_SESSION['user_name'];

$sql = "DELETE FROM `answers`
WHERE `cat_id` = '{$categories_id}'
AND `genre_id` = '{$genres_id}'
AND `users_user_name` = '{$user_name}'";

run_sql($conn, $sql);


header("Location: ./?type=account");