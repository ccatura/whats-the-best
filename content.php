<?php

$type = '';
$desc = '';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $desc = $_GET['desc'];
    $cat_id = get_cat_id_from_name($conn, $desc);
} else {
    $type = "home";
}

// change the '3' to the dynamic category ID
$sql         = "SELECT data.name, count(*) as totals, data.id FROM answers
                INNER JOIN `data` ON data.id = answers.data_id WHERE data.cat_id = $cat_id
                GROUP BY answers.data_id ORDER BY totals DESC";

echo "Count of Most Popular in Category: {$desc}<br><br>";
get_category_stats($conn, $sql, $cat_id);
echo '<br><br>';

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