<?php

    $from       = $_SESSION['user_name'];
    $to         = $_GET['the_user'];

    if (!empty($_POST)) {
        $subject    = $_POST['subject'];
        $message    = $_POST['message'];
    
        echo   "from: {$from}<br>
                to: {$to}<br>
                ";
    message($conn, $from, $to, $subject, $message);
    header('Location: ' . $_SERVER['HTTP_REFERER']);


} else {
    echo   "<form class='message-single' action='#' method='post'>
            Send message to: {$to}<br><br>
            <input type='hidden' name='to' value='{$to}'>
            Subject
            <input type='text' name='subject' required>
            Message
            <textarea name='message' required></textarea>
            <input type='submit' name='submit'>
            </form>";
}





