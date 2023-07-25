

<form action="#" method="post">
    <div>
    <div>Email Address<br><input type="text" name="email" placeholder="Email Address"></div>
    <div><input type="submit" name="submit" value="Recover Account"></div>
    <div>* THIS WILL RESET YOUR PASSWORD.</div>
</form>




<?php

if (!empty($_POST)) {
    $email          = strtolower($_POST['email']);
    $new_pword      = mt_rand(10000000,99999999);
    $new_pword_hash = hash('sha256', $new_pword);

    $sql = "UPDATE `users` SET `pword` = '{$new_pword_hash}' WHERE email = '{$email}';";
    run_sql($conn, $sql);
    $result = mysqli_query($conn,"SELECT `user_name`, `name`, `email`, `pword` FROM `users` WHERE email = '{$email}' LIMIT 1;");

    // recover here
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            // $db_pword = $row['pword'];
            $db_name = $row['name'];
            $db_email = $row['email'];
            $pword        = hash('sha256', $pword);

            
            $subject = "MeetMeInThe80s Account Recovery";
            $message = "You requested a password recovery, well... here it is. Don't lose it again!<br><br>Password: {$new_pword}<br>Login <a href='http://meetmeinthe80s.com/apps/whats-the-best'>HERE</a>";

            email($db_user_name, $db_name, $db_email, $subject, $message);
        }
    // no user name found
    } else {
        echo 'User not found';
    }
}
