<?php
require('./functions.php');
include('./db-connect.php');
session_start();


$category = $_POST['Category'];
$user_name = $_SESSION['user_name'];

// echo $_SESSION['user_name'];

foreach ($_POST as $genre => $value) {
    $exists = false;
    $data_id = '';
    $name = str_replace("'", "\'", $value);

    if ($value != 'submit' && $value != '' && $genre != 'Category') {
        // Check if name exists
        $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
        $exists = check_db_exist($conn, $sql);

        // Enter new data entries, if they exist, they get ignored
        $sql = "INSERT INTO `data` (`name`) VALUES ('{$name}');";
        if ($exists == false) {
            $result = mysqli_query($conn, $sql);
            $data_id = get_data_id_from_name($conn, $name);
            $to = 'ccatura@gmail.com';
            $subject = 'New data created';
            $message = "<strong>{$user_name}</strong> created a new data: <strong>{$name} ({$data_id})</strong>";

            email($user_name, $name, $to, $subject, $message);
        
        }
        // I CLEANED THIS NEXT BLOCK UP, BUT KEPT IT JUST IN CASE
        // Get ID of previously entered answer... IF PREVIOUSLY DID NOT EXIST IN DB
        // $sql = "SELECT `name`, `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
        // $data_id = get_data_id($conn, $sql);
        $data_id = get_data_id_from_name($conn, $name);

        // Enter new answers, there can be duplicates but not for same category/genre combined for each user, but not data_id
        $sql = "INSERT INTO `answers` (`users_user_name`, `data_id`, `cat_id`, `genre_id`) VALUES ('{$user_name}', '{$data_id}', '{$category}', '{$genre}') ON DUPLICATE KEY UPDATE `data_id`='{$data_id}';";
        $result = mysqli_query($conn, $sql);
        echo $sql . '<br><br>';
    }
}
$_SESSION['message'] = "Your votes have been submitted!";

// $sql         = "SELECT data.name, count(*) as totals FROM answers
//                 INNER JOIN `data` ON data.id = answers.data_id WHERE data.cat_id = {$category}
//                 GROUP BY answers.data_id ORDER BY totals DESC";

// get_category_stats($conn, $sql, $category);
// echo '<br><br>';
if ($_SESSION['how-to'] != true) {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        header("Location: ./type=how-to-3&desc=Congratulations!");
    }
}

?>




