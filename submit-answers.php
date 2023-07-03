<?php
require('./functions.php');
include('./db-connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$category = $_POST['Category'];

// Create the SQL
foreach ($_POST as $genre => $value) {
    $exists = false;
    $data_id = '';
    $name = str_replace("'", "\'", $value);

    // Check if name exists
    $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
    $exists = check_db_exist($conn, $sql);

    // Enter new entries, if they exist, it gets ignored
    if ($value != 'submit' && $genre != 'Category' && $exists == false) {
        $result = mysqli_query($conn, "INSERT INTO `data` (`name`, `cat_id`) VALUES ('{$name}', '{$category}');");
    }

    $data_id = get_data_id($conn, $sql);

    // Enter new answers, there can be duplicates
    if ($value != 'submit' && $genre != 'Category') {
        $result = mysqli_query($conn, "INSERT INTO `answers` (`data_id`, `cat_id`, `genre_id`) VALUES ('{$data_id}', '{$category}', '{$genre}');");
    }
}




echo 'Thanks!!';


?>
</body>
</html>



