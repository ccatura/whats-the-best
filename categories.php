<?php


    echo get_category_stats($conn, $cat_id);
    echo '<br><br>';

    if (isset($_SESSION['user_name'])) {
        echo '* Voting for a different answer in the same genre will replace your existing vote.<br><br>';
        echo get_genres_and_inputs($conn, $desc);
    } else {
        echo '<a href="./?type=login&desc=Login" style="text-decoration: underline;">Login to vote.</a>';
    }

