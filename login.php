<?php

if(!isset($_GET['register'])) {

    echo "<div class='message-single' style='max-width: 500px; text-align: center;'>Welcome to 'What's the Best?' – an exciting web app in development that aims to determine the top picks from the iconic eras of the 70s, 80s, and 90s. Join our community, cast your votes, and let's collectively identify the ultimate favorites in movies, books, retro computers, stores, restaurants, and more. Sign up today and play a crucial role in shaping this unique platform!</div><br>";

    echo   '<form action="#" method="post">
                <input type="hidden" name="login-type" value="login">
                <div>User Name<br><input type="text" name="user_name" placeholder="User Name"></div>
                <div>Password<br><input type="password" name="pword" placeholder="Password"></div>
                <a href="./?type=recover&desc=Recover Account">I Forgot My Password</a>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./?register=true"><div>Click Here to Register</div></a>
                
            </form>';
} else {
    echo   '<form action="#" method="post">
                <input type="hidden" name="login-type" value="register">
                <div>Choose User Name<br><input type="text" name="user_name" placeholder="Choose User Name" minlength="4" required></div>
                <div>Real Name<br><input type="text" name="name" placeholder="Real Name" required></div>
                <div>Year Born<br><input type="number" name="year_born" placeholder="Year Born" minlength="4" min="1923" max="2020" required></div>
                <div>Email<br><input type="email" name="email" placeholder="Email" minlength="6" required></div>
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
    $email = $_POST['email'];

    $result = mysqli_query($conn,"SELECT `name`, `user_name`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    // login here
    if ($_POST['login-type'] == 'login' && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            $db_pword = $row['pword'];

            // Compare passwords for login
            if ($user_name == $db_user_name && $pword == $db_pword) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                header("Location: ./");
                exit;
            }
        }
    // register here
    } elseif ($_POST['login-type'] == 'register' && mysqli_num_rows($result) < 1) {
        $result = mysqli_query($conn,"INSERT INTO `users` (`user_name`, `pword`, `year_born`, `name`, `email`) VALUES ('{$user_name}', '{$pword}', '{$year_born}', '{$name}', '{$email}');");
        if ($result) {
            $_SESSION['user_name'] = $user_name;
            $_SESSION['name'] = $name;

            $subject = 'Welcome to MeetMeInThe80s!';
            $message  = "Welcome {$name},";
            $message .= "You have signed up to the MeetMeInThe80s.com app: 'What's the Best?' with user name: {$user_name}.";
            $message .= "To get started, login at <a href='http://meetmeinthe80s.com/apps/whats-the-best'>MeetMeInThe80s.com/apps/whats-the-best</a>";
        
            email($user_name, $name, $email, $subject, $message);
            header("Location: ./");
            exit;
        }
    } else {
        echo 'There was a problem. Please try again.';
    }
}

