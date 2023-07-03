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

$category    = $_POST['Category'];


foreach ($_POST as $genre => $value) {
    $exists = false;
    $data_id = '';
    $name = str_replace("'", "\'", $value);

    // Check if name exists
    $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
    $exists = check_db_exist($conn, $sql);

    // Enter new entries, if they exist, it gets ignored
    $sql = "INSERT INTO `data` (`name`, `cat_id`) VALUES ('{$name}', '{$category}');";
    if ($value != 'submit' && $value != '' && $genre != 'Category' && $exists == false) {
        $result = mysqli_query($conn, $sql);
    }
    // Get ID of previously entered answer... IF PREVIOUSLY DID NOT EXIST IN DB
    $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
    $data_id = get_data_id($conn, $sql);

    // Enter new answers, there can be duplicates
    $sql = "INSERT INTO `answers` (`data_id`, `cat_id`, `genre_id`) VALUES ('{$data_id}', '{$category}', '{$genre}');";
    if ($value != 'submit' && $value != '' && $genre != 'Category') {
        $result = mysqli_query($conn, $sql);
    }
}

$sql         = "SELECT data.name, count(*) as totals FROM answers
                INNER JOIN `data` ON data.id = answers.data_id WHERE data.cat_id = {$category}
                GROUP BY answers.data_id ORDER BY totals DESC";

// get_category_stats($conn, $sql, $category);
// echo '<br><br>';
if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

?>
</body>
</html>



