<?php

$year_count = get_users_years_combined($conn); // Needs to pass $conn to the function because it does a query
echo "This is the {$desc} page.<br><br>";
echo "There are active users born in {$year_count} different years.";
