<?php

if (isset($_GET['data_id'])) {
    $data_id = $_GET['data_id'];
    $data_name = get_name_from_data_id($conn, $data_id);
}

$name_clean = str_replace(' ', '-', $data_name);
echo '<img class="large-image" src="./images/data/'.$name_clean.'.jpg" style="margin-bottom:2em;" onerror="this.src=\'./images/data/no-image.jpg\'">';
echo "<div>All Votes</div>";
echo get_votes_for_data_genre($conn, $data_id);