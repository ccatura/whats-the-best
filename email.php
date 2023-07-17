<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();

$user_name = $_GET['user_name'];
$name      = $_GET['name'];
$email     = $_GET['email'];
$subject   = $_GET['subject'];
$message   = $_GET['message'];
$type      = $_GET['type'];
$desc      = $_GET['desc'];

$_SESSION['message'] = 'Message sent!';

echo "the user: {$user_name}<br>";
echo "the name: {$name}<br>";
echo "the email: {$email}<br>";
echo "subject: {$subject}<br>";
echo "message: {$message}<br>";



email($the_user, $the_name, $the_email, $subject, $message);

echo "type: {$type}<br>desc: {$desc}";

// header("Location: ./?type={$type}&desc={$desc}");
