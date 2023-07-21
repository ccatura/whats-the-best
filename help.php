<?php

    $to      = 'ccatura@gmail.com';
    $from    = $_SESSION['user_name'];
    $name    = $_SESSION['name'];
    $subject = 'Help request from MMIN8';

    if (!empty($_POST)) {
        $message     = "Message from: {$from} ($name)<br>";
        $message    .= $_POST['message'];
        email($from, $name, $to, $subject, $message);
        // header('Location: ' . $_SERVER['HTTP_REFERER']);


    } else {
        echo   "<form class='message-single' action='#' method='post'>
                Send message to<strong>Help</strong><br>
                <input type='hidden' name='to' value='{$to}'>
                Subject<strong>Need Help at MeetMeInThe80s.com</strong><br>
                Describe your issue
                <textarea name='message' required></textarea><br>
                Please remember that this site is in development,<br>
                so most of the issues that exist will be naturally<br>
                resolved in the coarse of regular development.
                <input type='submit' name='submit'>
                </form>";
    }





