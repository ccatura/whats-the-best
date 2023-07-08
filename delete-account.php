<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$user_name = $_SESSION['user_name'];

$sql = "DELETE FROM `answers`
WHERE `cat_id` = '{$categories_id}'
AND `genre_id` = '{$genres_id}'
AND `users_user_name` = '{$user_name}'";

// run_sql($conn, $sql);

$_SESSION['message'] = "Account <strong>{$user_name}</strong> deleted . Sorry to see you go, dude.";
echo $sql . '<br>';
echo $_SESSION['message'];

// header("Location: ./?type=account");