<?php



if (is_admin($conn, $_SESSION['user_name'])) {
    echo "<div class='config-single'><div class='toggle config-heading'>Genres</div>";
    echo get_config_genres($conn) . "</div>";
    echo "<div class='config-single' id='categories-config'><div class='toggle config-heading'>Categories</div>";
    echo get_config_categories($conn) . "</div>";
    echo "<div class='config-single' id='delete-data-config'><div class='toggle config-heading'>Delete Data</div>";
    echo get_config_delete_data($conn) . "</div>";
    echo "<div class='config-single' id='combine-data-config'><div class='toggle config-heading'>Combine Data</div>";
    echo get_config_combine_data($conn) . "</div>";
    echo "<div class='config-single' id='make-admin-config'><div class='toggle config-heading'>Make Admin</div>";
    echo config_make_admin($conn) . "</div>";
}
?>

<div class='side-menu'>
    <div class='menu-items'>
        <a href='#top'>Top</a>
        <a href='#categories-config'>Categories</a>
        <a href='#delete-data-config'>Delete Data</a>
        <a href='#combine-data-config'>Combine Data</a>
        <a href='#make-admin-config'>Make Admin</a>
    </div>
</div>

