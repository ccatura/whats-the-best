<?php
if (isset($_GET['session'])) {
    if ($_GET['session'] == 'false') {
        session_unset();
    }
}

echo '<a href="./">home</a><br>';


if (isset($_SESSION['user_name'])) {
    // $user_name = $_SESSION['user_name'];
    echo 'user_name: ' . $_SESSION['user_name'] . '<br>';
    echo '<a href="./?session=false">logout</a><br><br>';
}


echo get_categorie_buttons($conn);
echo get_year_buttons($conn);


?>