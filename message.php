<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();

$from       = $_SESSION['user_name'];
$to         = $_GET['user_name'];
$name       = $_GET['name'];
$subject    = $_GET['subject'];
$message    = $_GET['message'];


echo "name: {$name}";
message($conn, $from, $to, $subject, $message);

header("Location: ./");
