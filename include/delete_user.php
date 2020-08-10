<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="../css/style.css" rel="stylesheet">

</head>
<div class="form-box">
    <?php
    session_start();
    include_once 'config.php';

    if (isset($_POST['Delete-Account'])) {

        $pass = $_POST['Password'];
        $user = $_POST['user'];

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

        //get user password
        $query = "SELECT * FROM `user` WHERE user_id=$user";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $userPass = $row['password'];
        $goto="../sign_in.php";
        //check that password matches one on record
        if (password_verify($pass, $userPass)) {
                    //wait for transaction to be complete before commit
                    mysqli_autocommit($db, FALSE);

                    /* Insert some values */
                    mysqli_query($db, "DELETE FROM `user` WHERE `user_id`= $user");
                    mysqli_query($db, "DELETE FROM `likes` WHERE `user_id`= $user");
                    
                    /* commit transaction */
                    if (!mysqli_commit($db)) {
                        print("Transaction commit failed\n");
                        $goto="../account.php";
                    }else{
                        session_unset();
                        session_destroy();
                        print "<p>Your account was deactivate successful. You can sign up for a new account at anytime!</p>";
                        echo "<p> You have been securely loged out. We hope to see you again on Exposure</p>";
                    }
                 
            
        } else {
            print "<p>Your entered your password incorrectly. So we can deactivate your account.</p>";
            $goto="../account.php";
        }
    }

    ?>
    <button id="upload-con" onclick="window.location.href='<?php echo $goto?>';">Continue</button>
</div>