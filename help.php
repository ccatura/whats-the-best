<?php

if (!isset($_SESSION['user_name'])) {
    echo "<a href='./?type=login&desc=Login'>Login to use help</a>";
    exit;
}


    $to      = 'ccatura@gmail.com';
    $from    = $_SESSION['user_name'];
    $name    = $_SESSION['name'];
    $subject = "Help request from {$name} ({$from})";

    if (!empty($_POST)) {
        $message     = "Message: <br>";
        $message    .= $_POST['message'];
        email($from, $name, $to, $subject, $message);
        message($conn, $from, 'admin', $subject, $message);
        $_SESSION['message'] = "Your help request was sent.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo   "<form class='alert-single' action='#' method='post'>
                Send message to<strong>Help</strong><br>
                <input type='hidden' name='to' value='{$to}'>
                From<strong>{$from} ({$name})</strong><br>
                Subject<strong>Need Help at `What`s the Best?`</strong><br>
                Describe your issue
                <textarea name='message' required></textarea><br>
                Please remember that this site is in development,<br>
                so most of the issues that exist will be naturally<br>
                resolved in the coarse of regular development.
                <input type='submit' name='submit'>
                </form>";
    }





