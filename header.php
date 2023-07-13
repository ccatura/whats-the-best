<?php

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'] . '<br><br>';
}

if (isset($_GET['session'])) {
    if ($_GET['session'] == 'false') {
        session_unset();
        // session_destroy();
    }
}


echo '<div class="section"><a href="./" class="sub link button" title="Go to Home Page">Home</a>';


if (isset($_SESSION['user_name'])) {
    // echo 
    echo '<a href="./?type=account" class="sub link button" title="' . $_SESSION['name'] . '">' . $_SESSION['user_name'] . ' &#9776;</a><br>';
    if ($_SESSION['user_name'] == 'ccatura') {
        echo '<a href="./?type=config&desc=Config" class="sub link button">Config</a>';
    }
    echo '<span class="sub link button" id="logout">Logout</span></div>';
}


echo get_category_buttons($conn);
echo get_year_buttons($conn);


?>