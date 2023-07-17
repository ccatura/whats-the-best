<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();
$user_name = $_SESSION['user_name'];


$fields = $_POST;
$non_empty_fields_count = count(array_filter($fields));
$sql = "UPDATE `users` SET ";

$count = 0;
foreach ($fields as $field => $value) {
    if ($field !='submit' && $value != '' && $value != null) {
        $sql .= "`{$field}` = '{$value}'";
        if ($count == ($non_empty_fields_count -1)) {
            $sql .= ' ';
        } else {
            $sql .= ', ';
        }
        $count++;
    }
}
echo 'non empty fields count: ' . $non_empty_fields_count . '  count: ' . $count . '<br>';
$sql .= " WHERE `user_name` = '{$user_name}'";
echo $sql;


if ($non_empty_fields_count != 0) {
    run_sql($conn, $sql);
    $_SESSION['message'] = "Account updated!";
}

header("Location: ./?type=account");
