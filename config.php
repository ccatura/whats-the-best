<?php



if (is_admin($conn, $_SESSION['user_name'])) {
    echo '<a href="#config_categories">Skip to Categories</a>';
    echo '<h2>Genres</h2>';
    echo get_config_genres($conn);
    echo '<h2 id="config_categories">Categories</h2>';
    echo get_config_categories($conn);
    echo '<h2>Delete Data</h2>';
    echo get_config_delete_data($conn);
    echo '<h2>Combine Data</h2>';
    echo get_config_combine_data($conn);
    echo '<h2>Make Admin</h2>';
    echo config_make_admin($conn);
}
?>

