<?php


if(!isset($_GET['register'])) {

    echo "<div style='width: 300px; text-align: center;'>Welcome to 'What's the Best?'. This app is in progress, so if something doesn't work correctly, it's probably being worked on at the moment. But, feel free to look around and even creat an account and put in some votes. I'd love people to help me test this out while I work out the bugs! PS. You will not be asked for personal information and should not write anything personal here. Thank!</div><br>";

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
                <div>Choose User Name<br><input type="text" name="user_name" placeholder="Choose User Name" minlength="4" required></div>
                <div>Real Name<br><input type="text" name="name" placeholder="Real Name" required></div>
                <div>Year Born<br><input type="number" name="year_born" placeholder="Year Born" minlength="4" min="1923" max="2020" required></div>
                <div>Choose Password<br><input type="password" name="pword" placeholder="Choose Password" minlength="8" required></div>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./"><div>Have and account?<br>Login Here</div></a>
            </form>';
}





if (!empty($_POST)) {
    $user_name = strtolower($_POST['user_name']);
    $pword = $_POST['pword'];
    $year_born = $_POST['year_born'];
    $name = $_POST['name'];

    $result = mysqli_query($conn,"SELECT `name`, `user_name`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    // login here
    if ($_POST['login-type'] == 'login' && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            $db_pword = $row['pword'];

            if ($user_name == $db_user_name && $pword == $db_pword) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
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