<?php
session_start();
include_once 'include/config.php';
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

//check that they arrived here the correct way
if (isset($_POST['log-in-submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    //use sanitation
    $query = "SELECT * FROM `user` WHERE email=?;";
    if ($statement = mysqli_prepare($db, $query)) {

        // bind parameters s - string,
        $result = mysqli_stmt_bind_param($statement, 's', $email);
        if (!$result) {
            header("location: login.php?error=sqlerror");
        }
        // execute query
        mysqli_stmt_execute($statement);
        $result=mysqli_stmt_get_result($statement);
        //check if email matches
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            //check if password matches
            if (password_verify($pass, $row['password'])) {
                //set session var
                $_SESSION['userId'] = $row['user_id'];
                header("location: gallery.php");
            } else {
                header("location: login.php?error=noPassMatch&email=".urlencode($email));
            }
        } else {
            
            //echo mysqli_num_rows($result);
            header("location: login.php?error=noUser");
        }
    } else {
        header("location: login.php?error=sqlerror");
    }
} else {
    //echo "test";
    header("location: login.php");
}
