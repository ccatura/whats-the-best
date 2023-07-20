<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$data_id = $_GET['data_id'];
$data_name = $_GET['data_name'];
$categories_id = $_GET['categories_id'];
$genres_id = $_GET['genres_id'];
$genres_name = $_GET['genres_name'];
$user_name = $_SESSION['user_name'];
$the_user = $_GET['the_user'];

$sql = "DELETE FROM `answers`
WHERE `cat_id` = '{$categories_id}'
AND `genre_id` = '{$genres_id}'
AND `users_user_name` = '{$the_user}'";

run_sql($conn, $sql);

$_SESSION['message'] = "Deleted '{$data_name}' from genre '{$genres_name}'";
echo $sql . '<br>';
echo $_SESSION['message'];

header('Location: ' . $_SERVER['HTTP_REFERER']);

// header("Location: ./?type=account");