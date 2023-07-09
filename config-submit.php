<?php
include_once('./db-connect.php');
include_once('./functions.php');
session_start();

$data = $_POST;
$sql_genre = '';
$sql_cat = '';

if ($data['form_type'] == 'genres') {
  foreach ($data as $cat_genre => $value) {
    $cat_id = '';
    $genre_id = '';

  // NEED TO PUT IN A CONSTRAINT INCASE DUPLICATE GENRE BEING ENTERED FOR CAT AND GENRE

    if ($cat_genre =='submit' || $cat_genre =='checkbox_count' || $cat_genre =='form_type') continue;

    if ($cat_genre != 'new') {
      list($cat_id, $genre_id) = explode("_", $cat_genre, 2);
      $sql_genre .= "INSERT INTO `cat_genre` (`cat_id`, `genre_id`) VALUES ({$cat_id}, {$genre_id});";
    } elseif (!empty($value)) {
      $sql_genre .= "INSERT INTO `genres` (`name`) VALUES ('{$value}');";
    }
  }
  submit_config_genres($conn, $sql_genre);
  echo $sql_genre;

} elseif ($data['form_type'] == 'categories' && $data['new'] != '') {
  // echo $sql_cat . '<br>' . $data['new'];
  foreach ($data as $category => $value) {
    if ($category !='submit' && $category !='checkbox_count' && $category !='form_type') {
      $sql_cat .= "INSERT INTO `categories` (`name`) VALUES ('{$data['new']}');";
    }
  }
  submit_config_categories($conn, $sql_cat);
  echo $sql_cat;

}


// header("Location: ./?type=config&desc=Config");





?>