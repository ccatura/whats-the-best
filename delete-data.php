<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$data_id = $_GET['data_id'];
$data_name = $_GET['data_name'];
$user_name = $_SESSION['user_name'];

$sql = "DELETE FROM `answers`
WHERE `data_id` = '{$data_id}'";
run_sql($conn, $sql);

$sql = "DELETE FROM `data`
WHERE `id` = '{$data_id}'";
run_sql($conn, $sql);

$_SESSION['message'] = "Deleted '{$data_name}' forever!";
echo $sql . '<br>';
echo $_SESSION['message'];

header("Location: ./?type=config&desc=Config");