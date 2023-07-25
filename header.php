<?php
$message_count = '';
$m_count = '';

// Display message if exists
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'] . '<br><br>';
    unset($_SESSION['message']);
}

if (isset($_GET['session'])) {
    if ($_GET['session'] == 'false') {
        session_unset();
        session_destroy();
        // header("Location: ./");
    }
}

if (isset($_SESSION['user_name'])) {
    $message_count = get_message_count($conn, $_SESSION['user_name']);
    if ($message_count == 0) {
        $m_count = '';
    } else {
        $m_count = '(' . $message_count . ')';
    }
}



if (isset($_SESSION['user_name'])) {
    echo '<div class="section"><a href="./" class="sub link button" title="Go to Home Page">Home</a>';
    // echo 
    echo '<a href="./?type=account&desc=Account" class="sub link button" title="' . $_SESSION['name'] . '">' . $_SESSION['user_name'] . ' &#9776;</a><br>';
    if (is_admin($conn, $_SESSION['user_name'])) {
        echo '<a href="./?type=config&desc=Config" class="sub link button">Config</a>';
    }
    echo "<a href='./?type=messages&desc=Messages' class='sub link button' title='Messages'>Messages {$m_count}</a><br>";
    echo '<span class="sub link button" id="logout">Logout</span></div>';
} else {
    echo '<div class="section"><a href="./" class="sub link button" title="Go to Home Page">Login</a>';
}


echo get_category_buttons($conn);
echo get_year_buttons($conn);


?>