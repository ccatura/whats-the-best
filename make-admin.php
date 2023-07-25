<?php
require('./functions.php');
include('./db-connect.php');
session_start();

$user_name  = $_POST['user_name'];
if (isset($_POST['make-admin'])) {
    $make_admin = 1;
} else {
    $make_admin = 0;
}


echo "username: {$user_name}  - {$make_admin}<br><br>";

$sql = "UPDATE `users` SET `admin` = {$make_admin} WHERE `user_name` = '{$user_name}'";
run_sql($conn, $sql);
echo $sql . '<br>';

$_SESSION['message'] = 'Update admin priviledges.';

header("Location: ./?type=config&desc=Config");