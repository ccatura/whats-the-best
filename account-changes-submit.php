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

    echo $field . ' ' . $value . '<br>';
    if ($field == 'file-to-upload' && $value != '') $count++;

    if ($field !='submit' && $field != 'file-to-upload' && $value != '' && $value != null) {
        echo 'field ' . $field . '   value: ' . $value . '<br><br>';
        if ($field == 'pword') {
            $value = hash('sha256', $value);
        }
        if ($non_empty_fields_count > 0) $sql .= "`{$field}` = '{$value}'";
        if ($count == ($non_empty_fields_count -1)) {
            $sql .= ' ';
        } else {
            $sql .= ', ';
        }
        $count++;
    }
}
echo '(non-empty fields) fields with data in them: ' . $non_empty_fields_count . '  count: ' . $count . '<br>';
$sql .= " WHERE `user_name` = '{$user_name}'";
echo $sql;

echo '<br><br>File: ' . $_FILES['file-to-upload']['name'];

if (!empty($_FILES['file-to-upload']['name'])) {
    prepare_images_uploaded($_FILES, $user_name);
}

if ($non_empty_fields_count != 0) {
    run_sql($conn, $sql);
    $_SESSION['message'] = "Account updated!";
}

header("Location: ./?type=account");
