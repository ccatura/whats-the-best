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
        $categories .= '<a href="./?type=category&desc=' . $cat_name . '"><div class="sub cat">' . $cat_name . '</div></a>';
    }
    $categories .= '</div>';
    return $categories;
}


function get_year_buttons($conn) {
    $result = mysqli_query($conn,"SELECT DISTINCT `year_born` FROM `users` ORDER BY `year_born`");

    $years  =   '<div id="users" class="section">
                <div class="sec-title">User Stats</div>';

    while ($row = mysqli_fetch_assoc($result)) {
        $year = $row['year_born'];
        $years .= '<a href="./?type=year&desc=' . $year . '"><div class="sub year">' . $year . '</div></a>';
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
        INNER JOIN categories ON categories.id = data.cat_id
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

function submit_answers($conn, $sql) {

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
    // $data_id = $row['id'];
}
