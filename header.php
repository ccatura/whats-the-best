<?php
$user = $_SESSION['user'];
echo "User: {$user}";


echo get_categorie_buttons($conn);
echo get_year_buttons($conn);


?>