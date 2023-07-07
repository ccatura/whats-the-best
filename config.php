<?php
if ($_SESSION['user_name'] == 'ccatura') {
    echo get_config_genres($conn);
}
?>
