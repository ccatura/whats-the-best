

<form action="#" method="post">
    <div>
    <div>User Name<br><input type="text" name="user_name" placeholder="User Name"></div>
    <div><input type="submit" name="submit" value="Recover Account"></div>
</form>




<?php

if (!empty($_POST)) {
    $user_name = strtolower($_POST['user_name']);

    $result = mysqli_query($conn,"SELECT `user_name`, `name`, `email`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    // recover here
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            $db_pword = $row['pword'];
            $db_name = $row['name'];
            $db_email = $row['email'];
            
            $subject = "MeetMeInThe80s Account Recovery";
            $message = "You requested a password recovery, well... here it is. Don't lose it again!<br><br>Password: {$db_pword}<br>Login <a href='http://meetmeinthe80s.com/apps/whats-the-best'>HERE</a>";

            email($db_user_name, $db_name, $db_email, $subject, $message);
        }
    // no user name found
    } else {
        echo 'User not found';
    }
}
