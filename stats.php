<?php

if (isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_name = get_name_from_data_id($conn, $data_id);
}

$name_clean = str_replace(' ', '-', $data_name);
$data_image = get_image($conn, 'data_pics', $data_name, 'large');

echo "<img class='large-image' src='{$data_image}' style='margin-bottom:2em;'>";
echo "<div>All Votes</div>";
echo get_votes_for_data_genre($conn, $data_id);