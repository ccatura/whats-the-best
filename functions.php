<?php

function get_users_years_combined($conn) {
    // I don't think I'm using this
    // Get count of all user years born combined
    // For example, 10 users are born in 1973 and 4 are born in 1975, returns 2 for the 2 different years
    $result = mysqli_query($conn,"SELECT count(DISTINCT `year_born`) as 'year_born' FROM `users`");
    while ($row = mysqli_fetch_assoc($result)) {
        $year_count = $row['year_born'];
    }
    return $year_count;
}

function get_category_buttons($conn) {
    $result = mysqli_query($conn,"SELECT * FROM `categories` ORDER BY `name`");
    $categories =  "<div id='categories' class='section'>
                    <div class='sec-title'></div>";

    while ($row = mysqli_fetch_assoc($result)) {
        $cat_name = $row['name'];
        $categories .= "<a class='sub cat' href='./?type=category&desc={$cat_name}#content'>{$cat_name}</a>";
    }
    $categories .= "</div>";
    return $categories;
}

function get_year_buttons($conn) {
    $result = mysqli_query($conn,"SELECT DISTINCT `year_born`, count(*) as 'count' FROM `users` GROUP BY `year_born` ORDER BY `year_born`");
    $user_count = get_user_count($conn);
    $years  =  "<div id='users' class='section'>
                <a class='sub year' href='./?type=year&desc=All Users#content'>{$user_count} total users</a>";

    while ($row = mysqli_fetch_assoc($result)) {
        $year = $row['year_born'];
        $years .= "<a class='sub year' href='./?type=year&desc={$year}#content' title='{$row['count']} user(s)'>{$year}</a>";
    }
    $years .= "</div>";
    return $years;
}

function get_user_count($conn) {
    $result =  mysqli_query($conn,"SELECT count(*) as 'total' FROM `users` ORDER BY `year_born`");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['total'];
    }
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
        ORDER BY categories.name, genres.name"
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

    $output = "";
    while ($row_cat = mysqli_fetch_assoc($result_categories)) {
        $genre_name = $row_cat['genres_name'];
        $genre_id = $row_cat['genres_id'];
        $cat_id = $row_cat['categories_id'];
        $output .= "
        <form class='listings-container' action='./submit-answers.php' method='post'>
            <div class='listings-row'><div class='listing-label'>{$genre_name}: </div>";
        $placeholder = "";
        if (mysqli_num_rows($result_user) != 0) {
            foreach($sql_user_array as $x => $row_user) { // Puts user's choice into the input box
                if ($row_user['answers_genre_id'] == $genre_id) {
                    $placeholder = str_replace("'", "&lsquo;", $row_user['data_name']);
                }
            }
        }

        $data_id = get_data_id_from_name($conn, $placeholder);
        $cat_name = get_cat_name_from_id($conn, $cat_id);

        if ($placeholder != '') {
            $output .= "<strong>
                            <span onclick='popup(`Delete vote`, `Delete {$placeholder} from {$cat_name} / {$genre_name}?`, `./delete-answer.php?data_id={$data_id}&data_name={$placeholder}&genres_name={$genre_name}&categories_id={$cat_id}&genres_id={$genre_id}&the_user={$user_name}`)' class='pointer'>&#10005;</span>
                        </strong> ";
        }
        $output .= "<input class='listing-input' list='data' name='{$genre_id}' genre-id='{$genre_id}' placeholder='{$placeholder}'>";
        
        $output .= "</div>";

    }

    $output .= "<input type='hidden' name='Category' value='{$cat_id}'>
                <datalist id='data'>";
    while ($row_data = mysqli_fetch_assoc($result_data)) {
        $output .= "
        <option value=\"" . $row_data['data_name'] . "\">";
    }
    $output .= "</datalist>";
    $output .= "<button class='input-submit' name='submit' value='submit'>Submit All</button></form>";
    return $output;
}

function check_db_exist($conn, $sql) {
    // Checks if the sql returns any results
    // If yes, returns true, if no, returns false
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        return true;
    }
}

// Delete this if no problems arise
// function get_data_id($conn, $sql) {
//     $result = mysqli_query($conn, $sql);
//     while($row = mysqli_fetch_assoc($result)) {
//         return $row['id'];
//     }
// }

function get_data_id_from_name($conn, $name) {
    $sql = "SELECT `id` FROM `data` WHERE `name` = '$name' LIMIT 1;";
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

function get_cat_name_from_id($conn, $cat_id) {
    $result = mysqli_query($conn, "SELECT `name` FROM categories WHERE `id` = $cat_id LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
}

function get_genre_name_from_id($conn, $genres_id) {
    $result = mysqli_query($conn, "SELECT `name` FROM genres WHERE `id` = $genres_id LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['name'];
    }
}

function get_category_stats($conn, $cat_id) {
    // Gets stats from that category
    // Example: Lists all actors and their votes
    $sql = "SELECT data.name, count(*) as totals, data.id FROM answers
    INNER JOIN `data` ON data.id = answers.data_id
    WHERE answers.cat_id = {$cat_id}
    GROUP BY answers.data_id ORDER BY totals DESC, data.name";

    $result = mysqli_query($conn, $sql);
    $output = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $href = "./?type=stats&data_id={$row['id']}&cat_id={$cat_id}#content";
        $output .= "<a href='$href'>{$row['totals']} votes - {$row['name']}</a>";
    }
    return $output;
}

function get_top_stats($conn) {
    $sql = "SELECT data.name, count(*) as totals, data.id FROM answers
    INNER JOIN `data` ON data.id = answers.data_id
    GROUP BY answers.data_id ORDER BY totals DESC, data.name";

    $result = mysqli_query($conn, $sql);
    $output = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $name_clean = str_replace(' ', '-', $row['name']);
        $href = "./";
        $output .= "<a href='$href'>{$row['totals']} votes - {$row['name']}</a>";
        $output .= '<img class="large-image" src="./images/data/'.$name_clean.'.jpg" style="margin-bottom:2em;" onerror="this.src=\'./images/data/no-image.jpg\'">';
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
    $output = "";
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

function get_users_for_year($conn, $year) {
    if ($year == 'All Users') {
        $result = mysqli_query($conn,"SELECT * FROM `users` ORDER BY `year_born`");
    } else {
        $result = mysqli_query($conn,"SELECT * FROM `users` WHERE `year_born` = $year");
    }
    $output  = "<div id='users'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $the_user  = $row['user_name'];
        $the_name  = $row['name'];
        $the_email = $row['email'];

        if (isset($_SESSION['user_name'])) {
            $subject   = "Message from {$_SESSION['name']}";
            $message   = "Hi!";
        } else {
            $subject = "";
            $message = "";
        }

        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        // FIX ALL THE INLINE CSS IN THE FOILLOWING CODE!!!!!!
        $output .= "<div class='alert-single' style='color:black'>";
        $view_user =   "<a style='color:black' href='./?type=view-votes&desc={$the_user}&rsquo;s Votes&the_user={$the_user}'>{$the_user} - {$the_name}</a>";
        
        if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != $the_user) {
            $wtb_message = "<a style='color:black' href='./?type=wtb-message&desc=Send Message&the_user={$the_user}' title='Message {$the_name}'> &#9993; </a>";
            $say_hi = "<a style='color:black' href='./message.php?user_name={$the_user}&name={$the_name}&subject={$subject}&message={$message}' class='pointer' title='Say hi to {$the_name}'>&#128515;</a>";
        } else {
            $wtb_message = "";
            $say_hi = "";
        }

        if ($year == 'All Users') {
            $user_year = "<a style='color:black' href='?type=year&desc={$row['year_born']}#content'>{$row['year_born']}</a> ";
        } else {
            $user_year = "";
        }
        $output .= "<div style='text-align:center;width:100%;'><img class='profile-small' src='./images/user_pics/{$the_user}_thumb.jpg' onerror='this.style.opacity=0'></div>";
        $output .= "<div class='alert-row' style='width:100%'>{$user_year} {$view_user} {$say_hi} {$wtb_message}</div></div>";
    }
    $output .= "</div>";
    return $output;
}

function get_user_account($conn, $user_name) {
    // When user clicks on their account, this is where it is generated
    $result = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_name` = '$user_name';");

    while ($row = mysqli_fetch_assoc($result)) {
        $output = "<form class='listings-container' action='./account-changes-submit.php' method='post' enctype='multipart/form-data' autocomplete='off'>
                        <div class='listings-row'><div class='listing-label'>Real Name:</div> <input class='listing-input' type='text' name='name' placeholder='{$row['name']}'></div>
                        <div class='listings-row'><div class='listing-label'>User Name:</div> <input class='listing-input' type='text' name='user_name' placeholder='{$row['user_name']}' disabled title='Cannot change user name'></div>
                        <div class='listings-row'><div class='listing-label'>Year Born:</div> <input class='listing-input' type='text' name='year_born' placeholder='{$row['year_born']}' minlength='4' min='1923' max='2020'></div>
                        <div class='listings-row'><div class='listing-label'>Password:</div> <input class='listing-input' type='password' name='pword' minlength='8' autocomplete='off'></div>
                        <div class='listings-row'><div class='listing-label'>Profile Pic:</div> <img src='./images/user_pics/{$user_name}_thumb.jpg' onerror='this.style.opacity=0'> <input type='file' name='file-to-upload' id='file-to-upload'></div>
                        <input class='input-submit' type='submit' value='Submit Changes'>
                    </form>";

        if ($user_name != 'ccatura') {
            $output .= "<span href='./delete-account.php' class='warning pointer' id='delete-account'>Delete Account</span>";
        }
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

        $output .= "<div>";
        if (isset($_SESSION['user_name'])) {
            if ($user_name == $_SESSION['user_name'] || is_admin($conn, $_SESSION['user_name'])) {
                $output .= "<strong>
                                <span onclick='popup(`Delete vote`, `Delete {$data_name} from {$categories_name} / {$genres_name}?`, `./delete-answer.php?data_id={$data_id}&data_name={$data_name}&genres_name={$genres_name}&categories_id={$categories_id}&genres_id={$genres_id}&the_user={$user_name}`)' class='pointer'>&#10005;</span>
                            </strong>";
            }
        }
        $output .= "<a href='./?type=category&desc={$row['categories_name']}'>{$row['categories_name']}</a> 
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

function message($conn, $from, $to, $subject, $message) {
    $timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `messages` (`user_name_from`, `user_name_to`, `subject`, `message`, `timestamp`) VALUES ('{$from}', '{$to}', '{$subject}', '{$message}', '{$timestamp}')";
    
    // echo $sql . '<br><br>';
    run_sql($conn, $sql);
    $_SESSION['message'] = "Message sent!";
}

function get_user_messages($conn, $user_name) {
    $output = "";
    $sql = "SELECT * FROM `messages`
            JOIN `users` ON users.user_name = user_name_from
            WHERE `user_name_to` = '$user_name'
            ORDER BY `id` DESC";

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $date = strtotime($row['timestamp']);
        $formatted_date = date('M d, Y h:i:s', $date);
        $user_name_from = $row['user_name_from'];

        $output .= "<div class='alert-single'>
                        <img class='profile-small' src='./images/user_pics/{$user_name_from}_thumb.jpg' onerror='this.style.opacity=0'>
                        <div class='alert-row-date'><span onclick='popup(`Delete message`, `Delete current message? This cannot be undone.`, `./delete-message.php?message_id={$row['id']}`)' class='pointer'>&#10005;</span>
                        $formatted_date</div>
                        <div class='alert-row'><a href='./?type=wtb-message&desc=Send Message&the_user={$row['user_name_from']}' style='color:black'>{$row['name']} ({$row['user_name_from']})</a></div>
                        <div class='alert-row'>{$row['subject']}</div>
                        <div class='alert-row'>{$row['message']}</div>
                    </div>
                   ";
    }
    return $output;

}

function get_message_count($conn, $user_name) {
    $result =  mysqli_query($conn,"SELECT count(*) as 'count' FROM `messages` WHERE `user_name_to` = '$user_name' LIMIT 1");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['count'];
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

    $count      = 0;
    $checked    = "";
    $output     =  "<form class='section collapsed' id='config-genres' action='./config-submit.php' method='post'>
                    <div style='margin: 0 40%;'><input type='text' name='new' placeholder='Enter New Genre'>
                    <input type='submit' name='submit' value='Submit Genre Changes'></div>";
    $previous_cat_name = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['cat_name'] != $previous_cat_name) {
            $output .= "<p class='config-sec'>";
            $cat_name_non_repeat = $row['cat_name'];
            $previous_cat_name = $cat_name_non_repeat;
        } else {
            $cat_name_non_repeat = "";
        }

        $checked = "";
        foreach($sql_checked_array as $x => $row_checked) {
            if ($row['cat_id'] == $row_checked['cat_id'] && $row['genres_id'] == $row_checked['genre_id']) {
                $checked = "checked";
            }
        }

        $input_id = "{$row['cat_id']}_{$row['genres_id']}";
        $output .= "{$cat_name_non_repeat}<br>

        <span onclick='popup(`Delete Genre?`, `This will permanently delete the genre {$row['genres_name']} for ALL categories. This cannot be undone. Are you sure you want to delete it?`, `./delete-genre.php?genres_id={$row['genres_id']}`)' class='pointer'>&#10005;</span>

        <input type='checkbox' $checked id='{$input_id}' name='{$input_id}'> <label for='{$input_id}'>{$row['genres_name']}</label>";
        $count++;
    }
    $output .= "<br><br>
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


    $output = "<form class='collapsed' action='./config-submit.php' method='post'>
    <input type='text' name='new' placeholder='Enter New Category'><br><input type='submit' name='submit' value='Submit New Category'><br><br>";
    while ($row = mysqli_fetch_assoc($result)) {
        $input_id = $row['cat_id'];
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

function get_config_combine_data($conn) {
    $sql = "SELECT data.id as 'data_id', data.name as 'data_name'
            FROM data
            ORDER BY data.name";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $output =  "<form class='section collapsed' action='./combine-data.php' method='post'>
                Delete:
                <select name='data_id_delete'>";
    foreach($data as $x => $d) {
        $data_id = $d['data_id'];
        $data_name = $d['data_name'];
        $output .= "<option value='{$data_id}'>{$data_name} ({$data_id})</option>";
    }
    $output .= "</select>
                 and replace with:
                <select name='data_id'>";
    foreach($data as $x => $d) {
        $data_id = $d['data_id'];
        $data_name = $d['data_name'];
        $output .= "<option value='{$data_id}'>{$data_name} ({$data_id})</option>";
    }
    $output .= "</select>
                <br><br>
                <input type='submit' name='submit' value='Combine'>
                </form>";

    return $output;
}

function get_config_delete_data($conn) {
    $sql = "SELECT data.id, data.name
            FROM data
            ORDER BY data.name";
    $result = mysqli_query($conn, $sql);

    $output = "<div class='collapsed'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $data_id = $row['id'];
        $data_name = $row['name'];
        $output .= "<span onclick='popup(`Delete Data?`, `This will permanently delete the data and all  votes for: {$data_name}. This cannot be undone. Are you sure you want to delete it?`, `./delete-data.php?data_id={$data_id}&data_name={$data_name}`)' class='pointer'>&#10005;</span> {$data_name}<br>";
    }
    $output .= "<br><br></div>";
    return $output;
}

function config_make_admin($conn) {
    $sql = "SELECT *
            FROM users
            WHERE NOT user_name = 'ccatura'
            ORDER BY user_name";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    $output =  "<form class='collapsed' action='./make-admin.php' method='post'>
                <select name='user_name'>";
    foreach($users as $x => $d) {
        $user_name  = $d['user_name'];
        $name       = $d['name'];
        if ($d['admin'] == 1) {
            $is_admin = " - Admin";
        } else {
            $is_admin = "";
        }
        $output    .= "<option value='{$user_name}'>{$name} ({$user_name}) {$is_admin}</option>";
    }
    $output .= "</select>";

    $output .= "<br><br>
                <input type='checkbox' name='make-admin' id='make-admin' value='0'> <label for='make-admin'>Make admin</label><br><br>
                <input type='submit' name='submit' value='Submit'><br>
                * No checkmark revokes admin privileges.
                </form>";

    return $output;
}

function is_admin($conn, $user_name) {
    $result = mysqli_query($conn,"SELECT `admin` FROM `users` WHERE `user_name` = '$user_name' LIMIT 1;");
    while ($row = mysqli_fetch_assoc($result)) {
        return $row['admin'];
    }
}

function prepare_images_uploaded($files, $user_name) {
            $target_dir             = "./images/user_pics/";
            $original_file_name     = $target_dir . basename($files["file-to-upload"]["name"]); // Original name of image, including path to save it
            $imageFileType          = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION)); // The file's extension
            $new_thumb_name         = $target_dir . $user_name . '_thumb.jpg';
            $new_large_name         = $target_dir . $user_name . '_large.jpg';

            echo "target_dir: {$target_dir}<br>";
            echo "original_file_name: {$original_file_name}<br>";
            echo "imageFileType: {$imageFileType}<br>";

            $image_name     = $files["file-to-upload"]["tmp_name"];
            $image          = imagecreatefromjpeg ($image_name);
            $image_large    = imagescale($image , 500, -1);
            $image_thumb    = imagescale($image , 100, -1);

            imagejpeg($image_large, $new_large_name);
            imagejpeg($image_thumb, $new_thumb_name);
}