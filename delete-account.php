<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$user_name = $_SESSION['user_name'];

if ($user_name != 'admin') {
    $sql = "DELETE FROM `answers` WHERE `users_user_name` = '{$user_name}';";
    run_sql($conn, $sql);

    $sql = "DELETE FROM `messages` WHERE `user_name_to` = '{$user_name}';";
    run_sql($conn, $sql);

    $sql = "DELETE FROM `messages` WHERE `user_name_from` = '{$user_name}';";
    run_sql($conn, $sql);

    $sql = "DELETE FROM `users` WHERE `user_name` = '{$user_name}';";
    run_sql($conn, $sql);

    $_SESSION['message'] = "<div>Account <strong>{$user_name}</strong> deleted . Sorry to see you go, dude.</div>";
    echo $sql . '<br>';
    echo $_SESSION['message'];
}

header("Location: ./?session=false");
// header("Location: ./");