<?php

if (isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_name = get_name_from_data_id($conn, $data_id);
    $cat_id = $_GET['cat_id'];
}

echo $data_name . '<br>';
get_specific_stat($conn, $data_id, $cat_id);