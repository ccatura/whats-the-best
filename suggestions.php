<?php

if (!isset($_SESSION['user_name'])) {
    echo "<a href='./?type=login&desc=Login'>Login to suggest features</a>";
    exit;
}
    $to      = 'ccatura@gmail.com';
    $from    = $_SESSION['user_name'];
    $name    = $_SESSION['name'];
    $subject = "Suggestion from {$name} ({$from})";

    if (!empty($_POST)) {
        $message     = "Message: <br>";
        $message    .= $_POST['message'];
        email($from, $name, $to, $subject, $message);
        message($conn, $from, 'admin', $subject, $message);
        $_SESSION['message'] = "Your suggestion was sent.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    } else {
        echo   "<form class='alert-single' action='#' method='post'>
                Send message to<strong>Suggestions</strong><br>
                <input type='hidden' name='to' value='{$to}'>
                From<strong>{$from} ({$name})</strong><br>
                Subject<strong>Suggestions for What's the Best?</strong><br>
                Describe your suggestions
                <textarea name='message' required></textarea><br>
                Please remember that this site is in development,<br>
                so features are being worked on and added all the time<br>
                although, I look at suggestions and take into consideration<br>
                suggestions that may come multiple time from multiple users,<br>
                unless yours is just totally awesome!<br>
                <input type='submit' name='submit'>
                </form>";
    }





