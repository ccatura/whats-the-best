<?php

$type = '';
$desc = '';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $desc = $_GET['desc'];
} else {
    $type = "home";
}



if ($type == 'category') {
    // This is the category section
    echo "This is the category page of: {$desc}<br><br>";
    echo get_genres_and_inputs($conn, $desc);
} elseif ($type == 'year') {
    // This is the year section
    $year_count = get_users_years_combined($conn); // Needs to pass $conn to the function because it does a query
    echo "This is the {$desc} page.<br><br>";
    echo "There are active users born in {$year_count} different years.";
}




?>