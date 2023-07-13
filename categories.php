<?php

$sql = "SELECT data.name, count(*) as totals, data.id FROM answers
INNER JOIN `data` ON data.id = answers.data_id
WHERE answers.cat_id = {$cat_id}
GROUP BY answers.data_id ORDER BY totals DESC, data.name";

    echo get_category_stats($conn, $sql, $cat_id);
    echo '<br><br>';

    if (isset($_SESSION['user_name'])) {
        echo '* Voting for a different answer in the same genre will replace your existing vote.<br><br>';
        echo get_genres_and_inputs($conn, $desc);
    } else {
        echo '<a href="./" style="text-decoration: underline;">Login to vote.</a>';
    }

