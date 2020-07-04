<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="../css/style.css" rel="stylesheet">

</head>
<div class="form-box">
    <?php
    include_once 'config.php';

    if (isset($_POST['Password-change'])) {

        $oldPass = $_POST['Old-Password'];
        $newPass = $_POST['New-Password'];
        $conNewPass = $_POST['D-Check-Password'];
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

        //check that password matches one on record
        if (password_verify($oldPass, $userPass)) {
            //check if password is strong enough
            if (!(preg_match('/[A-Za-z]/', $newPass) && preg_match('/[0-9]/', $newPass))) {
                echo '<p> New password must contain at least one letter and one number</p>';
            } else {
                if ($newPass == $conNewPass) {
                    $hashPass=password_hash($newPass, PASSWORD_DEFAULT);
                    //use sanitation
                    $query = "UPDATE `user` SET `password`= ? WHERE `user`.`user_id` = ?";
                    if ($statement = mysqli_prepare($db, $query)) {
                    
                        // bind parameters s - string,
                        $result = mysqli_stmt_bind_param($statement, 'ss', $hashPass, $user);
                        if (!$result) {
                            print "<p>bounding error</p>";
                        }
                        // execute query
                        $result = mysqli_stmt_execute($statement);

                        if ($result) {
                            print "<p>Your password was changed successful</p>";
                        } else {
                            print "Mysql insert Error" . mysqli_stmt_error($statement);
                        }
                    }
                } else {
                    echo '<p> Passwords do not match</p>';
                }
            }
        } else {
            print "<p>Your entered your old password incorrectly. So we can update you password.</p>";
        }
    }

    ?>
    <button id="upload-con" onclick="window.location.href='../account.php';">Continue</button>
</div>