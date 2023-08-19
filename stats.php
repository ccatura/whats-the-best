<?php

if (isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_name = get_name_from_data_id($conn, $data_id);
}

$data_image = get_image($conn, 'data_pics', $data_name, 'large');

$data_image = get_search_image($data_name); // temp till i straighten the stuff out

// echo "<img class='large-image' src='{$data_image}' style='margin-bottom:2em;'>";

echo "<div class='large-image' style='background-image:url({$data_image});margin-bottom:2em;background-position:center;background-size:cover;height:350px;margin-bottom:2em;backgounrd-color:black;'></div>";

echo "<div>All Votes</div>";
echo get_votes_for_data_genre($conn, $data_id);


