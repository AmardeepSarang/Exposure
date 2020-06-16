<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link href="css/style.css" rel="stylesheet">

</head>
<?php
session_start();
include_once 'include/config.php';
?>
<div class="form-box">
    <?php

$email = $_POST['email'];
$name = $_POST['name'];
$pass = $_POST['password'];
$conPass = $_POST['confirm-password'];
$hasError = false;
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
//error checking
//check if any of the feilds are empty
if ($email == "" || $name == "" || $pass == "" || $conPass == "") {
    print "<p>One or more feilds are empty </p>";
    $hasError = true;
}

//check for correct email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print "<p> Invalid email format </p>";
    $hasError = true;
}

//check if email exits in db

//use sanitation
$query = "SELECT * FROM `user` WHERE email='$email'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    print "<p> An account is already using this email.</p>";
    $hasError = true;
}

//check if password is strong enough
if (!(preg_match('/[A-Za-z]/', $pass) && preg_match('/[0-9]/', $pass)))
{
    echo '<p> Password must contain at least one letter and one number</p>';
    $hasError=true;
}

//check if password match
if ($pass!=$conPass) {
    echo '<p> Passwords do not match</p>';
    $hasError=true;
}

if ($hasError) {
    print "<p>Please fix these errors.  </p>";
} else {
    $hashPass=password_hash($pass, PASSWORD_DEFAULT);
    

    //insert new user row
     //use sanitation
     $query = "INSERT INTO `user` (`user_id`, `email`, `name`, `password`) VALUES (NULL, ?, ?, ?);";
     if ($statement = mysqli_prepare($db, $query)) {

         // bind parameters s - string,
         $result = mysqli_stmt_bind_param($statement, 'sss', $email, $name, $hashPass);
         if (!$result) {
             print "<p>bounding error</p>";
         }
         // execute query
         $result = mysqli_stmt_execute($statement);

         if ($result) {
            print "<p>You have successfully signed up for Exposure! </p>";;
         } else {
             print "Mysql insert Error" . mysqli_stmt_error($statement);
         }
     }

    

    
}

    ?>
    <button id="upload-con" onclick="window.location.href='login.php';">Continue</button>
</div>