<?php
if (isset($_GET['session'])) {
    if ($_GET['session'] == 'false') {
        session_unset();
    }
}


echo '<div class="section"><a href="./" class="sub link" title="Go to Home Page">Home</a>';


if (isset($_SESSION['user_name'])) {
    // echo 
    echo '<a href="./?type=account" class="sub link" title="' . $_SESSION['name'] . '">' . $_SESSION['user_name'] . ' &#9776;</a><br>';
    if ($_SESSION['user_name'] == 'ccatura') {
        echo '<a href="./?type=config&desc=Config Genres" class="sub link">Config Genres</a>';
    }
    echo '<a href="./?session=false" class="sub link">Logout</a></div>';
}


echo get_categorie_buttons($conn);
echo get_year_buttons($conn);


?>