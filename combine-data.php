<?php

require('./functions.php');
include('./db-connect.php');
session_start();

$data_id_delete     = $_POST['data_id_delete'];
$data_name_delete   = get_name_from_data_id($conn, $data_id_delete);
$data_id            = $_POST['data_id'];
$data_name          = get_name_from_data_id($conn, $data_id);
$user_name          = $_SESSION['user_name'];



echo "
data_id_delete {$data_id_delete} <br>
data_name_delete {$data_name_delete} <br>
data_id {$data_id} <br>
data_name {$data_name} <br>
";








$sql = "UPDATE `answers`
SET `data_id` = '{$data_id}'
WHERE `data_id` = '{$data_id_delete}'";
run_sql($conn, $sql);
echo $sql . '<br>';

$sql = "DELETE FROM `data`
WHERE `id` = '{$data_id_delete}'";
run_sql($conn, $sql);

$_SESSION['message'] = "Replaced '{$data_name_delete}' with '{$data_name}'";
echo $sql . '<br>';
echo $_SESSION['message'];

header("Location: ./?type=config&desc=Config");