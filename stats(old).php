<?php

if (isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_name = get_name_from_data_id($conn, $data_id);
    $cat_id = $_GET['cat_id'];
}

echo $data_name . '<br>';
$name_clean = str_replace(' ', '-', $data_name);
echo '<img class="large-image" src="./images/data/'.$name_clean.'.jpg" style="margin-bottom:2em;" onerror="this.src=\'./images/data/no-image.jpg\'">';
echo get_specific_stat($conn, $data_id, $cat_id);