<?php

$user_name = $_SESSION['user_name'];

echo 'Enter new password to change it.<br><br>';
echo get_user_account($conn, $user_name);
echo "<br><br>Your Votes:";
echo get_user_votes($conn, $user_name);




