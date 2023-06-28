<?php

$result = mysqli_query($conn,"SELECT * FROM `categories` ORDER BY `name`");
$categories =  '<div id="categories" class="section">
                <div class="sec-title">Categories</div>';

while ($row = mysqli_fetch_assoc($result)) {
    $cat_name = $row['name'];
    $categories .= '<a href="./?type=category&cat=' . $cat_name . '"><div class="sub cat">' . $cat_name . '</div></a>';
}
$categories .= '</div>';



$result = mysqli_query($conn,"SELECT * FROM `years`");
$years =   '<div id="users" class="section">
            <div class="sec-title">User Stats</div>';

while ($row = mysqli_fetch_assoc($result)) {
    $year = $row['year'];

    $years .= '<a href="./?type=year&cat=' . $year . '"><div class="sub year">' . $year . '</div></a>';
}


$years .= '</div>';


echo $categories;
echo $years;

?>