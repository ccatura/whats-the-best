<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();
$user_name = $_SESSION['user_name'];


$fields = $_POST;
$fields_count = count(array_filter($fields));
$sql = "UPDATE `users` SET ";

$count = 2;
foreach ($fields as $field => $value) {
    if ($field !='submit' && $value != '' && $value != null) {
        $sql .= "`{$field}` = '{$value}'";
        if ($count == $fields_count) {
            $sql .= ' ';
        } else {
            $sql .= ', ';
        }
    } 
    $count++;
}
$sql .= " WHERE `user_name` = '{$user_name}'";
run_sql($conn, $sql);

header("Location: ./?type=account");
