<?php

    $to      = 'ccatura@gmail.com';
    $from    = $_SESSION['user_name'];
    $name    = $_SESSION['name'];
    $subject = 'Help request from What`s the Best?';

    if (!empty($_POST)) {
        $message     = "Help request from: {$from} ({$name})<br>";
        $message    .= $_POST['message'];
        email($from, $name, $to, $subject, $message);
        message($conn, $from, 'ccatura', $subject, $message);
        $_SESSION['message'] = "Your help request was sent.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);


    } elseif (!isset($_SESSION['user_name'])) {
        echo "<a href='./'>Login to use help</a>";
    } else {
        echo   "<form class='alert-single' action='#' method='post'>
                Send message to<strong>Help</strong><br>
                <input type='hidden' name='to' value='{$to}'>
                From<strong>{$from} ({$name})</strong><br>
                Subject<strong>Need Help at `What`s the BEst?`</strong><br>
                Describe your issue
                <textarea name='message' required></textarea><br>
                Please remember that this site is in development,<br>
                so most of the issues that exist will be naturally<br>
                resolved in the coarse of regular development.
                <input type='submit' name='submit'>
                </form>";
    }





