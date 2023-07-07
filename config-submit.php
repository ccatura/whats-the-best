<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();

$genres = $_POST;
$sql = '';

foreach ($genres as $cat_genre => $n) {
  $cat_id = '';
  $genre_id = '';
  if ($cat_genre !='submit' && $cat_genre !='checkbox_count') {
    list($cat_id, $genre_id) = explode("_", $cat_genre, 2);
    $sql .= "INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ({$cat_id}, {$genre_id});";
  }

}

submit_config_genres($conn, $sql);
// $result = mysqli_multi_query($conn, $sql);

echo $sql;

























?>