<?php

function get_users_years_combined($conn) {
    // Get count of all user years born combined
    $result = mysqli_query($conn,"SELECT count(DISTINCT `year_born`) as 'year_born' FROM `users`");
    while ($row = mysqli_fetch_assoc($result)) {
        $year_count = $row['year_born'];
    }
    return $year_count;
}

function get_categorie_buttons($conn) {
    $result = mysqli_query($conn,"SELECT * FROM `categories` ORDER BY `name`");
    $categories =  '<div id="categories" class="section">
                    <div class="sec-title">Categories</div>';

    while ($row = mysqli_fetch_assoc($result)) {
        $cat_name = $row['name'];
        $categories .= '<a href="./?type=category&desc=' . $cat_name . '#content"><div class="sub cat">' . $cat_name . '</div></a>';
    }
    $categories .= '</div>';
    return $categories;
}

function get_user_count($conn) {
    $result =  mysqli_query($conn,"SELECT count(*) as 'total' FROM `users` ORDER BY `year_born`");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
}

function get_year_buttons($conn) {
    $result = mysqli_query($conn,"SELECT DISTINCT `year_born` FROM `users` ORDER BY `year_born`");
    $user_count = get_user_count($conn);
    $years  =   '<div id="users" class="section">
                <div class="sec-title">There are ' . $user_count . ' Users Registered</div>';

    while ($row = mysqli_fetch_assoc($result)) {
        $year = $row['year_born'];
        $years .= '<a href="./?type=year&desc=' . $year . '#content"><div class="sub year">' . $year . '</div></a>';
    }
    $years .= '</div>';
    return $years;
}

function get_genres_and_inputs($conn, $desc) {
    // Gets genres of category selected with input boxes for user to submit
    // Makes the form
    $result_categories = mysqli_query($conn,
        "SELECT
        categories.name as 'catergories_name',
        categories.id   as 'categories_id',
        genres.name     as 'genres_name',
        genres.id       as 'genres_id'
        FROM `cat_genre`
        INNER JOIN categories ON categories.id = cat_genre.cat_id
        INNER JOIN genres     ON genres.id     = cat_genre.genre_id
        WHERE categories.name = '$desc'
        ORDER BY   categories.name, genres.name"
    );
    
    $result_data = mysqli_query($conn,
        "SELECT
        data.name as 'data_name'
        FROM `data`
        INNER JOIN categories
        WHERE categories.name = '$desc'
        ORDER BY   data.name"
    );

    $output = '';
    while ($row = mysqli_fetch_assoc($result_categories)) {
        $genre_name = $row['genres_name'];
        $genre_id = $row['genres_id'];
        $cat_id = $row['categories_id'];
        $output .= "
        <form action='./submit-answers.php' method='post'>
        <label>{$genre_name}: 
            <input list='data' name='{$genre_id}' genre-id='{$genre_id}'>
        </label><br>";
    }

    $output .= "<input type='hidden' name='Category' value='{$cat_id}'>
                <datalist id='data'>";
    while ($row = mysqli_fetch_assoc($result_data)) {
        $output .= "
        <option value=\"" . $row['data_name'] . "\">";
    }
    $output .= "</datalist>";
    $output .= "<button name='submit' value='submit'>Submit All</button></form>";
    return $output;
}

function check_db_exist($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        return true;
    }
}

function get_data_id($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        return $row['id'];
    }
}

function get_cat_id_from_name($conn, $name) {
    $result = mysqli_query($conn, "SELECT `id` FROM categories WHERE `name` = '$name' LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['id'];
    }
}

function get_category_stats($conn, $sql, $category) {
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $href = "./?type=stats&data_id={$row['id']}&cat_id={$category}#content";
        echo "<a href='$href'>{$row['totals']} votes - {$row['name']}</a>";
    }
}

function get_specific_stat($conn, $data_id, $cat_id) {
    $sql     = "SELECT genres.name, count(*) as 'totals'
                FROM answers
                INNER JOIN `genres` ON genres.id = answers.genre_id
                WHERE answers.data_id = $data_id
                AND answers.cat_id = $cat_id
                GROUP BY genres.name";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "{$row['totals']} votes - {$row['name']}<br>";
    }
}

function get_name_from_data_id($conn, $data_id) {
    $result = mysqli_query($conn, "SELECT `name` FROM data WHERE `id` = '$data_id' LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
}

function get_config($conn) {
    $sql = "SELECT categories.id as 'cat_id', categories.name as 'cat_name', genres.id as 'genres_id', genres.name as 'genres_name'
            FROM categories
            CROSS JOIN genres
            ORDER BY categories.name, genres.name;";

    $sql_checked    = "SELECT * FROM cat_genre ORDER BY cat_genre.cat_id;";
    $result         = mysqli_query($conn, $sql);
    $result_checked = mysqli_query($conn, $sql_checked);
    while ($row_checked = mysqli_fetch_assoc($result_checked)) {
        $sql_checked_array[] = $row_checked;
    }

    $count = 0;
    $checked = '';
    $output = '<form action="./config-submit.php" method="post">';
    $previous_cat_name = '';
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['cat_name'] != $previous_cat_name) {
            $output .= "<br><br>";
            $cat_name_non_repeat = $row['cat_name'];
            $previous_cat_name = $cat_name_non_repeat;
        } else {
            $cat_name_non_repeat = '';
        }

        $checked = '';
        foreach($sql_checked_array as $x => $row_checked) {
            if ($row['cat_id'] == $row_checked['cat_id'] && $row['genres_id'] == $row_checked['genre_id']) {
                $checked = 'checked';
            }
        }

        $input_id = "{$row['cat_id']}_{$row['genres_id']}";
        $output .= "{$cat_name_non_repeat}<br><input type='checkbox' $checked id='{$input_id}' name='{$input_id}'> <label for='{$input_id}'>{$row['genres_name']}</label>";
        $count++;
    }
    $output .= "<br><br><input type='submit' name='submit' value='Submit'><div><input type='hidden' name='checkbox_count' value='{$count}'></div></form>";
    echo $output;
}

function submit_config($conn, $sql) {
    $erase = "DELETE FROM `cat_genre` WHERE 1;";
    $erase_result = mysqli_query($conn, $erase);

    $result = mysqli_multi_query($conn, $sql);

    // while ($row = mysqli_fetch_assoc($result)) {

    // }

}

function get_users_for_year($conn, $year) {
    $result = mysqli_query($conn,"SELECT * FROM `users` WHERE `year_born` = $year");

    $output  = '<div id="users">
                <div class="sec-title">Year Stats</div><br>';

    while ($row = mysqli_fetch_assoc($result)) {
        $the_user = $row['user_name'];
        $the_name = $row['name'];
        $output .= "<div>{$the_name} ({$the_user})</div>";
    }
    $output .= '</div>';
    return $output;
}