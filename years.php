<?php

$year_count = get_users_years_combined($conn);
$year = $desc;

echo get_users_for_year($conn, $year);

