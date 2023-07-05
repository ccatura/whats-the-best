<?php
require('./functions.php');
include('./db-connect.php');
session_start();


$category = $_POST['Category'];
$user_name = $_SESSION['user_name'];

echo $_SESSION['user_name'];

foreach ($_POST as $genre => $value) {
    $exists = false;
    $data_id = '';
    $name = str_replace("'", "\'", $value);

    // Check if name exists
    $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
    $exists = check_db_exist($conn, $sql);

    // Enter new data entries, if they exist, they get ignored
    $sql = "INSERT INTO `data` (`name`, `cat_id`) VALUES ('{$name}', '{$category}');";
    if ($value != 'submit' && $value != '' && $genre != 'Category' && $exists == false) {
        $result = mysqli_query($conn, $sql);
    }
    // Get ID of previously entered answer... IF PREVIOUSLY DID NOT EXIST IN DB
    $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
    $data_id = get_data_id($conn, $sql);

    // this needs to be corrected to change an answer if it exists
    // Enter new answers, there can be duplicates but not for same type/genre/ combined for each user, but not data_id
    $sql = "INSERT IGNORE INTO `answers` (`users_user_name`, `data_id`, `cat_id`, `genre_id`) VALUES ('{$user_name}', '{$data_id}', '{$category}', '{$genre}') ON DUPLICATE KEY UPDATE `data_id`='{$data_id}';";
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




