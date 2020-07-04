<?php
session_start();
include_once 'include/config.php';
include_once 'include/gallery_user_functions.php';
include_once 'include/getuser.php';

//get user
$user = getSessionUser();


// Connect to MySQL
$db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

// Error checking
if (!$db) {
    print "<p>Error - Could not connect to MySQL</p>";
    exit;
}
$error = mysqli_connect_error();

if ($error != null) {
    $output = "<p>Unable to connet to database</p>" . $error;
    exit($output);
}

$query = "SELECT * FROM `user` WHERE user_id=$user";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings Page </title>
    <link href="css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c4c79ee8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital@1&display=swap" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
</head>


<body>
    <!--
        main nav bar
    -->
    <nav class="main-nav">
        <div class="logo">
            <img src="images/logo.png">

        </div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <div class="post-bt">
            <a href="#"><i class="fas fa-plus"></i>&nbsp Post new image</a>
        </div>
        <ul class="nav-links">
        <li><a href="gallery.php"><i class="fas fa-th"></i>&nbsp Gallery</a></li>
            <li><a href="user.php"><i class="fas fa-house-user"></i>&nbsp My dashboard</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</a></li>
            <li><a href="about.html"><i class="fas fa-question-circle"></i>&nbsp About</a></li>
        </ul>

        
    </nav>

    <div class="user-settings">
        <div class="sidebar">
            <h2>Account Settings </h2>
            <ul>
                <li><a href="#"><i class="fa fa-wrench" aria-hidden="true"></i>   Edit Profile </a></li>
                <li><a href="#"><i class="fa fa-lock" aria-hidden="true"></i>   Chnage Password </a> </li>
                <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>   Logout </li>
                <li><a href="#"><i class="fa fa-user-times" aria-hidden="true"></i>   Deactivate Account </a> </li>
            </ul>
        </div>
        <div class="settings">
            <div class="header"> Edit Profile </div>
            <form class="info" action="include/user_update.php" method="POST" enctype="multipart/form-data">
             <!--   Name <br>
                <input type="text" name="Name" id="fname" value="Jerin John"><br><br>
              -->
                User Name <br>
                <input type="text" name="Username" id="uname" value="<?php echo $row['name']?>"><br><br>
                E-mail <br>
                <input type="text" name="E-Mail" id="email" value="<?php echo $row['email']?>"><br><br>
                <input type="hidden" name="user" value="<?php echo $row['user_id']?>">
                <button type="submit" name="Update-Info">Update Info</button>
            </form>
            <div class="header"> Change Password </div>
            <form class="info" action="include/change_password.php" method="POST" enctype="multipart/form-data">
                Enter Old Password <br>
                <input type="password" name="Old-Password" id="opass" value=""><br><br>
                Enter New Passowrd <br>
                <input type="password" name="New-Password" id="npass" value=""><br><br>
                Confirm New Password <br>
                <input type="password" name="D-Check-Password" id="cpass" value=""><br><br>
                <input type="hidden" name="user" value="<?php echo $row['user_id']?>">
                <button type="submit" name="Password-change">Change Password</button>
            </form>
            <div class="header"> Deactivate Account </div>
            <form class="info">
                Enter Passowrd <br>
                <input type="password" name="Password " id="dpass" value=""><br><br>
                <input type="hidden" name="user" value="<?php echo $row['user_id']?>">
                <button type="submit" name="Delete-Accoutn">Deactive Account</button>
            </form>
        </div>
    </div>

    </div>
    <script src="js/nav.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>


</body>


    

    