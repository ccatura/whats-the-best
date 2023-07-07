<?php

$sql = "SELECT data.name, count(*) as totals, data.id FROM answers
INNER JOIN `data` ON data.id = answers.data_id
WHERE answers.cat_id = {$cat_id}
GROUP BY answers.data_id ORDER BY totals DESC";

    get_category_stats($conn, $sql, $cat_id);
    echo '<br><br>';

    if (isset($_SESSION['user_name'])) {
        echo get_genres_and_inputs($conn, $desc);
    } else {
        echo '<a href="./">Login to vote for shit</a>';
    }

