<?php

if(!isset($_GET['register'])) {

    echo "<div class='alert-single' style='max-width: 500px; text-align: center;'>Welcome to 'What's the Best?' – an exciting web app in development that aims to determine the top picks from the iconic eras of the 70s, 80s, and 90s. Join our community, cast your votes, and let's collectively identify the ultimate favorites in movies, books, retro computers, stores, restaurants, and more. Sign up today and play a crucial role in shaping this unique platform!</div><br>";

    echo   '<form action="./?type=login" method="post">
                <input type="hidden" name="login-type" value="login">
                <div>User Name<br><input type="text" name="user_name" placeholder="User Name"></div>
                <div>Password<br><input type="password" name="pword" placeholder="Password"></div>
                <a href="./?type=recover&desc=Recover Account">I Forgot My Password</a>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./?register=true"><div>Click Here to Register</div></a>
                
            </form>';
} else {
    echo   '<form action="./?type=login" method="post" enctype="multipart/form-data">
                <input type="hidden" name="login-type" value="register">
                <div>Choose User Name<br><input type="text" name="user_name" placeholder="Choose User Name" minlength="4" required></div>
                <div>Real Name<br><input type="text" name="name" placeholder="Real Name" required></div>
                <div>Year Born<br><input type="number" name="year_born" placeholder="Year Born" minlength="4" min="1923" max="2020" required></div>
                <div>Email<br><input type="email" name="email" placeholder="Email" minlength="6" required></div>
                <div>Profile Pic<br><input type="file" name="fileToUpload" id="fileToUpload"></div>
                <div>Choose Password<br><input type="password" name="pword" placeholder="Choose Password" minlength="8" required></div>
                <div><input type="submit" name="submit" value="Submit"></div>
                <a href="./"><div>Have and account?<br>Login Here</div></a>
            </form>';
}

if (!empty($_POST)) {
    $user_name = strtolower($_POST['user_name']);
    $pword = $_POST['pword'];

    $result = mysqli_query($conn,"SELECT `name`, `user_name`, `pword` FROM `users` WHERE user_name = '{$user_name}' LIMIT 1;");

    // login here
    if ($_POST['login-type'] == 'login' && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $db_user_name = $row['user_name'];
            $db_pword     = $row['pword'];
            $pword        = hash('sha256', $pword);


            // Compare passwords for login
            if ($user_name == $db_user_name && $pword == $db_pword) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                // header("Location: ./");
                echo "<script>window.location.replace('./');</script>";
                exit;
            }
        }
    // register here
    } elseif ($_POST['login-type'] == 'register' && mysqli_num_rows($result) < 1) {
        // $year_born  = $_POST['year_born'];
        // $name       = $_POST['name'];
        // $email      = $_POST['email'];
        // $pword      = hash('sha256', $pword);


        // $result = mysqli_query($conn,"INSERT INTO `users` (`user_name`, `pword`, `year_born`, `name`, `email`, `admin`) VALUES ('{$user_name}', '{$pword}', '{$year_born}', '{$name}', '{$email}', 0);");
        // if ($result) {
        //     $_SESSION['user_name'] = $user_name;
        //     $_SESSION['name'] = $name;

        //     $subject = 'Welcome to MeetMeInThe80s!';
        //     $message  = "Welcome {$name}!<br>";
        //     $message .= "You have signed up to the MeetMeInThe80s.com app: 'What's the Best?' using user name: {$user_name}. ";
        //     $message .= "To get started, login at <a href='http://meetmeinthe80s.com/apps/whats-the-best/?session=false'>MeetMeInThe80s.com/apps/whats-the-best</a>";
        
        //     email($user_name, $name, $email, $subject, $message);


        //     $subject = "Someone just registered on MMIT8";
        //     $message = "New user: {$user_name} - {$name}";
        //     email('ccatura', 'Charles Catura', 'ccatura@gmail.com', $subject, $message);
        //     $_SESSION['how-to'] = true;







            // IMAGE UPLOAD SECTION
            // IMAGE UPLOAD SECTION
            // IMAGE UPLOAD SECTION
                $target_dir             = "./images/user_pics/";
                $original_file_name     = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Original name of image, including path to save it
                $imageFileType          = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION)); // The file's extension
                $uploadOk               = 1;

                echo "target_dir: {$target_dir}<br>";
                echo "original_file_name: {$original_file_name}<br>";
                echo "imageFileType: {$imageFileType}<br>";



                // if($imageFileType != "jpg") {
                //     echo "Sorry, only JPG or JPEG files are allowed.";
                //     $uploadOk = 0;
                // }

                // if ($uploadOk == 0) {
                //     echo "Sorry, your file was not uploaded.";
                // } else {

                    $image_name                     = $_FILES["fileToUpload"]["tmp_name"];
                    $image                          = imagecreatefromjpeg ($image_name);
                    $image_profile                  = imagescale($image , 100, -1);
                    $target_file_resized_profile    = imagejpeg($image_profile, "{$original_file_name}");

                    echo "<br>";
                    echo "image_name: {$image_name}<br>";
                    echo "image: {$image}<br>";
                    echo "image_profile: {$image_profile}<br>";
                    echo "target_file_resized_profile: {$target_file_resized_profile}<br>";



                    // if (move_uploaded_file($image_name, $target_file_resized_profile)) {
                    //     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br><br>";
                    //     rename($original_file_name, $target_dir . $user_name . '_profile.jpg');
                    // } else {
                    //     echo "Sorry, there was an error uploading your file #1 <br><br>";
                    // }
                // }
            // END IMAGE UPLOAD SECTION
            // END IMAGE UPLOAD SECTION
            // END IMAGE UPLOAD SECTION








            // echo "<script>window.location.replace('./?type=how-to&desc=Awesome! You are logged in. Here is a quick guide on what to do...');</script>";

            // header("Location: ./?type=how-to&desc=Awesome! You are logged in. Here is a quick guide on what to do...");
            exit;
        }
    } else {
        echo 'There was a problem. Please try again.';
    }
// }

