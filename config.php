<?php
if ($_SESSION['user_name'] == 'ccatura') {
    echo '<a href="#config_categories">Skip to Categories</a>';
    echo '<h2>Genres</h2>';
    echo get_config_genres($conn);
    echo '<h2 id="config_categories">Categories</h2>';
    echo get_config_categories($conn);
}
?>

