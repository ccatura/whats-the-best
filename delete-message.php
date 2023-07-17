<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$message_id = $_GET['message_id'];
$user_name = $_SESSION['user_name'];


if ($user_name == 'ccatura') {
    $sql = "DELETE FROM `messages` WHERE `id` = $message_id;";
}

run_sql($conn, $sql);
$_SESSION['message'] = "Message deleted.";


header("Location: ./?type=messages&desc=Messages");