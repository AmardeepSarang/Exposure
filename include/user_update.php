<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User update</title>
    <link href="../css/style.css" rel="stylesheet">

</head>
<div class="form-box">
    <?php
    include_once 'config.php';

    if (isset($_POST['Update-Info'])) {

        $name = $_POST['Username'];
        $email = $_POST['E-Mail'];
        $user = $_POST['user'];
        //check for correct email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            print "<p> Invalid email format </p>";
        } else {
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

            //use sanitation
            $query = "UPDATE `user` SET `email`= ?,`name`=  ? WHERE `user`.`user_id` = ?";
            if ($statement = mysqli_prepare($db, $query)) {

                // bind parameters s - string,
                $result = mysqli_stmt_bind_param($statement, 'sss', $email, $name, $user);
                if (!$result) {
                    print "<p>bounding error</p>";
                }
                // execute query
                $result = mysqli_stmt_execute($statement);

                if ($result) {
                    print "<p>Your user name and/or email was updated successful</p>";
                } else {
                    print "Mysql insert Error" . mysqli_stmt_error($statement);
                }
            }
        }
    }

    ?>
    <button id="upload-con" onclick="window.location.href='../account.php';">Continue</button>
</div>