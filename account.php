<?php

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'] . '<br><br>';
        $_SESSION['message'] = null;
    }
} else {
    header("Location: ./");
}
echo 'Enter new password to change it.<br><br>';
echo get_user_account($conn, $user_name);
echo "<br><br>Your Votes:";
echo get_user_votes($conn, $user_name);




