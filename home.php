<?php

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    echo "<img class='large-image' src='./images/user_pics/{$user_name}_large.jpg' onerror='this.style.opacity=0'>";
}



echo "<div class='content-sub'>";


echo    "<div class='section-small'><h2>Current Champion in Total Votes</h2>";
echo    get_top_stats($conn, 3);
echo    "</div>";

echo    "<div class='section-small'><h2>Last Sign-Ups</h2>";
echo    get_last_sign_ups($conn, 5);
echo    "</div>";

echo "</div>";




// echo "<h2>All Data</h2>";
// echo get_all_data($conn);



// second place: runner up
// third place: 