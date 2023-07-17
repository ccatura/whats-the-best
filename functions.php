<?php

function get_users_years_combined($conn) {
    // Get count of all user years born combined
    $result = mysqli_query($conn,"SELECT count(DISTINCT `year_born`) as 'year_born' FROM `users`");
    while ($row = mysqli_fetch_assoc($result)) {
        $year_count = $row['year_born'];
    }
    return $year_count;
}

function get_category_buttons($conn) {
    $result = mysqli_query($conn,"SELECT * FROM `categories` ORDER BY `name`");
    $categories =  '<div id="categories" class="section">
                    <div class="sec-title"></div>';

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
                <div class="sec-title">There are ' . $user_count . ' registered users born in the following years:</div>';

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

    $cat_id = get_cat_id_from_name($conn, $desc);
    $user_name = $_SESSION['user_name'];
    $result_user = mysqli_query($conn,
        "SELECT  answers.genre_id as 'answers_genre_id',
        answers.data_id as 'answers_data_id',
        data.name as 'data_name'
        FROM answers
        INNER JOIN users ON users.user_name = answers.users_user_name
        INNER JOIN data ON data.id = answers.data_id
        WHERE users.user_name = '{$user_name}'
        AND answers.cat_id = $cat_id;"
    );
    if (mysqli_num_rows($result_user) != 0) {
        while ($row_user = mysqli_fetch_assoc($result_user)) { //puts query into array for multi-use
            $sql_user_array[] = $row_user;
        }
    }

    $result_data = mysqli_query($conn,
        "SELECT
        data.name as 'data_name'
        FROM `data`
        INNER JOIN categories
        WHERE categories.name = '$desc'
        ORDER BY   data.name"
    );

    $output = '';
    while ($row_cat = mysqli_fetch_assoc($result_categories)) {
        $genre_name = $row_cat['genres_name'];
        $genre_id = $row_cat['genres_id'];
        $cat_id = $row_cat['categories_id'];
        $output .= "
        <form action='./submit-answers.php' method='post'>
        <label>{$genre_name}: ";
        $placeholder = '';
        if (mysqli_num_rows($result_user) != 0) {
            foreach($sql_user_array as $x => $row_user) { // Puts user's choice into the input box
                if ($row_user['answers_genre_id'] == $genre_id) {
                    $placeholder = str_replace("'", "&lsquo;", $row_user['data_name']);
                }
            }
        }
        $output .= "<input list='data' name='{$genre_id}' genre-id='{$genre_id}' placeholder='{$placeholder}'></label><br>";

    }

    $output .= "<input type='hidden' name='Category' value='{$cat_id}'>
                <datalist id='data'>";
    while ($row_data = mysqli_fetch_assoc($result_data)) {
        $output .= "
        <option value=\"" . $row_data['data_name'] . "\">";
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
    $output = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $href = "./?type=stats&data_id={$row['id']}&cat_id={$category}#content";
        $output .= "<a href='$href'>{$row['totals']} votes - {$row['name']}</a>";
    }
    return $output;
}

function get_specific_stat($conn, $data_id, $cat_id) {
    $sql     = "SELECT genres.name, count(*) as 'totals'
                FROM answers
                INNER JOIN `genres` ON genres.id = answers.genre_id
                WHERE answers.data_id = $data_id
                AND answers.cat_id = $cat_id
                GROUP BY genres.name";

    $result = mysqli_query($conn, $sql);
    $output = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "{$row['totals']} votes - {$row['name']}<br>";
    }
    return $output;
}

function get_name_from_data_id($conn, $data_id) {
    $result = mysqli_query($conn, "SELECT `name` FROM data WHERE `id` = '$data_id' LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
}

function get_config_genres($conn) {
    $sql = "SELECT categories.id as 'cat_id', categories.name as 'cat_name', genres.id as 'genres_id', genres.name as 'genres_name'
            FROM categories
            CROSS JOIN genres
            ORDER BY categories.name, genres.name;";

    $sql_checked    = "SELECT * FROM cat_genre ORDER BY cat_genre.cat_id;";
    $result         = mysqli_query($conn, $sql);
    $result_checked = mysqli_query($conn, $sql_checked);
    while ($row_checked = mysqli_fetch_assoc($result_checked)) { //puts query into array for multi-use
        $sql_checked_array[] = $row_checked;
    }

    $count = 0;
    $checked = '';
    $output = "<form class='section' action='./config-submit.php' method='post'>
    <input type='text' name='new' placeholder='Enter New Genre' style='margin: 0 40%;'>";
    $previous_cat_name = '';
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['cat_name'] != $previous_cat_name) {
            $output .= "<p class='config-sec'>";
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
    $output .= "<br><br><input type='submit' name='submit' value='Submit Genre Changes' style='position: sticky;bottom: 0px;'>
    <input type='hidden' name='checkbox_count' value='{$count}'>
    <input type='hidden' name='form_type' value='genres'>
    </form>";
    return $output;
}

function submit_config_genres($conn, $sql) {
    $erase = "DELETE FROM `cat_genre` WHERE 1;";
    $erase_result = mysqli_query($conn, $erase);

    $result = mysqli_multi_query($conn, $sql);

    if ($result) {
        header("Location: ./?type=config&desc=Config");
    }
}

function get_config_categories($conn) {
    $sql = "SELECT categories.id as 'cat_id', categories.name as 'cat_name'
            FROM categories
            ORDER BY categories.name";
    $result = mysqli_query($conn, $sql);


    $output = "<form action='./config-submit.php' method='post'>
    <input type='text' name='new' placeholder='Enter New Category'><br><input type='submit' name='submit' value='Submit New Category'><br><br>";
    while ($row = mysqli_fetch_assoc($result)) {
        $input_id = "{$row['cat_id']}";
        $output .= "<span onclick='popup(`Delete Category?`, `This will permanently delete the category: {$row['cat_name']}. This cannot be undone. Are you sure you want to delete it?`, `./delete-category.php?cat_id={$input_id}`)' class='pointer'>&#10005;</span> {$row['cat_name']}<br>";
    }
    $output .= "<br><br>
    <input type='hidden' name='form_type' value='categories'>
    </form>";
    return $output;
}

function submit_config_categories($conn, $sql) {
    $result = mysqli_multi_query($conn, $sql);

    if ($result) {
        header("Location: ./?type=config&desc=Config");
    }
}

function get_users_for_year($conn, $year) {
    $result = mysqli_query($conn,"SELECT * FROM `users` WHERE `year_born` = $year");

    $output  = '<div id="users">';

    while ($row = mysqli_fetch_assoc($result)) {
        $the_user  = $row['user_name'];
        $the_name  = $row['name'];
        $the_email = $row['email'];
        $subject   = "Message from www.MeetMeInThe80s.com!";
        $message   = "User: {$_SESSION['user_name']} says hi! &lt;a href=`#`&gt;Click Here&lt;/a&gt; to say hi back!";
        if (isset($_SESSION['user_name']) /*&& $_SESSION['user_name'] != $the_user*/) {
            $say_hi = "<a href='./email.php?user_name={$the_user}&name={$the_name}&email={$the_email}&subject={$subject}&message={$message}&type=year&desc={$year}' class='pointer' title='Say hi to {$the_name}'>&#128515;</a>";
        } else $say_hi = '';
        $output .= "<div>{$say_hi} {$the_name} ({$the_user})</div>";
    }
    $output .= '</div>';
    return $output;
}

function get_user_account($conn, $user_name) {
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_name` = '$user_name';");

    while ($row = mysqli_fetch_assoc($result)) {
        $output = "<form action='./account-changes-submit.php' method='post'><div> 
        Real Name: <input type='text' name='name' placeholder='{$row['name']}'><br>
        User Name: <input type='text' name='user_name' placeholder='{$row['user_name']}' disabled title='Cannot change user name'><br>
        Year Born: <input type='text' name='year_born' placeholder='{$row['year_born']}' minlength='4' min='1923' max='2020'><br>
        Password: <input type='password' name='pword' minlength='8'><br>
        <input type='submit' value='Submit Changes'></div></form><br>
        <span href='./delete-account.php' class='warning pointer' id='delete-account'>Delete Account</span>";
    }
    return $output;
}

function get_user_votes ($conn, $user_name) {
    $sql = "SELECT
    data.name as 'data_name',
    categories.name as 'categories_name',
    genres.name as 'genres_name',
    answers.data_id as 'answers_data_id',
    answers.cat_id as 'answers_categories_id',
    answers.genre_id as 'answers_genres_id'
    FROM answers
    JOIN data ON data.id = answers.data_id
    JOIN categories ON categories.id = answers.cat_id
    join genres ON genres.id = answers.genre_id
    JOIN users ON users.user_name = answers.users_user_name
    WHERE answers.users_user_name = '{$user_name}'
    ORDER BY categories.name";

    $result = mysqli_query($conn, $sql);
    $output = "<div class='vote-list'>";

    while ($row = mysqli_fetch_assoc($result)) {
        // $data_name = $row['data_name'];
        $data_name = str_replace("'", "&lsquo;", $row['data_name']);
        $data_id = $row['answers_data_id'];
        // $categories_name = $row['categories_name'];
        $categories_name = str_replace("'", "&lsquo;", $row['categories_name']);
        $categories_id = $row['answers_categories_id'];
        // $genres_name = $row['genres_name'];
        $genres_name = str_replace("'", "&lsquo;", $row['genres_name']);
        $genres_id = $row['answers_genres_id'];
        $cat_id = get_cat_id_from_name($conn, $categories_name);

        $output .= "<div>
                        <strong>
                            <span onclick='popup(`Delete vote`, `Delete {$data_name} from {$categories_name} / {$genres_name}?`, `./delete-answer.php?data_id={$data_id}&data_name={$data_name}&genres_name={$genres_name}&categories_id={$categories_id}&genres_id={$genres_id}`)' class='pointer'>&#10005;</span>
                        </strong> 
                            <a href='./?type=category&desc={$row['categories_name']}'>{$row['categories_name']}</a> 
                        - {$row['genres_name']} - 
                        <strong>
                            <a href='./?type=stats&data_id={$data_id}&cat_id={$cat_id}#content'>{$row['data_name']}</a>
                        </strong>
                    </div>";
    }
    $output .= "</div>";
    return $output;
}

function run_sql($conn, $sql) {
    $result = mysqli_query($conn, $sql);
}

function email($user_name, $name, $to, $subject, $message) {
    $header[] = "From: charlie@meetmeinthe80s.com";
    $header[] = "MIME-Version: 1.0";
    $header[] = "Content-type: text/html";

    $sendmail = mail($to, $subject, $message, implode("\r\n", $header));
}