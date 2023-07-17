<?php
include_once('./db-connect.php');
include_once('./functions.php');

$the_user  = $_GET['the_user'];
$the_name  = $_GET['the_name'];
$the_email = $_GET['the_email'];
$subject   = $_GET['subject'];
$message   = $_GET['message'];
$type      = $_GET['type'];
$desc      = $_GET['desc'];

$_SESSION['message'] = 'Message sent!';


email($the_user, $the_name, $the_email, $subject, $message);

echo "the user: {$the_user}<br>";
echo "the name: {$the_name}<br>";
echo "the email: {$the_email}<br>";

echo "type: {$type} desc: {$desc}";

header("Location: ./?type={$type}&desc={$desc}");
