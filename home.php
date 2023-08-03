<?php

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    echo "<img class='large-image' src='./images/user_pics/{$user_name}_large.jpg' onerror='this.style.opacity=0'>";
}


echo "<h2>Current Champion in Total Votes</h2>";
// echo get_top_stats($conn);
echo get_all_data($conn);



// second place: runner up
// third place: 