<div><a href="./?session=true">Login</a></div>


<form action="#" method="post">
    <div>User Name<br><input type="text" name="user_name" placeholder="User Name"></div>
    <div>Password<br><input type="password" name="pword" placeholder="Password"></div>
    <div><input type="submit" name="submit" value="Submit"></div>
</form>




<?php

if (!empty($_POST)) {
    $user_name = $_POST['user_name'];
    $pword = $_POST['pword'];

    $result = mysqli_query($conn,"SELECT `user_name`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    while ($row = mysqli_fetch_assoc($result)) {
        $db_user_name = $row['user_name'];
        $db_pword = $row['pword'];

        if ($user_name == $db_user_name && $pword == $db_pword) {
        $_SESSION['user_name'] = $row['user_name'];
            header("Location: ./");
        }
    }
}
?>