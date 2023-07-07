<?php

if(!isset($_GET['register'])) {
    echo   '<form action="#" method="post">
                <input type="hidden" name="login-type" value="login">
                <div>User Name<br><input type="text" name="user_name" placeholder="User Name"></div>
                <div>Password<br><input type="password" name="pword" placeholder="Password"></div>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./?register=true"><div>Click Here to Register</div></a>
            </form>';
} else {
    echo   '<form action="#" method="post">
                <input type="hidden" name="login-type" value="register">
                <div>Choose User Name<br><input type="text" name="user_name" placeholder="Choose User Name"></div>
                <div>Real Name<br><input type="text" name="name" placeholder="Real Name"></div>
                <div>Year Born<br><input type="number" name="year_born" placeholder="Year Born"></div>
                <div>Choose Password<br><input type="password" name="pword" placeholder="Choose Password"></div>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./"><div>Have and account?<br>Login Here</div></a>
            </form>';
}





if (!empty($_POST)) {
    $user_name = strtolower($_POST['user_name']);
    $pword = $_POST['pword'];
    $year_born = $_POST['year_born'];
    $name = $_POST['name'];

    $result = mysqli_query($conn,"SELECT `user_name`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    // login here
    if ($_POST['login-type'] == 'login' && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            $db_pword = $row['pword'];

            if ($user_name == $db_user_name && $pword == $db_pword) {
                $_SESSION['user_name'] = $row['user_name'];
                header("Location: ./");
            }
        }
    // register here
    } elseif ($_POST['login-type'] == 'register' && mysqli_num_rows($result) < 1) {
        $result = mysqli_query($conn,"INSERT INTO `users` (`user_name`, `pword`, `year_born`, `name`) VALUES ('{$user_name}', '{$pword}', '{$year_born}', '{$name}');");
        if ($result) {
            $_SESSION['user_name'] = $user_name;
            header("Location: ./");
        }
    } else {
        echo 'That user name exists. Please choose another.';
    }
}
?>