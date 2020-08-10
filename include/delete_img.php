<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete image</title>
    <link href="../css/style.css" rel="stylesheet">

</head>
<div class="form-box">
    <?php
    session_start();
    include_once 'config.php';
    include_once 'gallery_user_functions.php';
    include_once 'getuser.php';

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

    //check if admin
    $admin = isAdmin($db, $user);
    if ($admin) {
        if (isset($_GET['id'])) {//protect aganst SQL injection
            $id = $_GET['id'];
            

            if (is_numeric($id)) {
                $path = getPath($db, $id);
                //wait for transaction to be complete before commit
                mysqli_autocommit($db, FALSE);

                /* Insert some values */
                mysqli_query($db, "DELETE FROM `image` WHERE `Img_id`= $id");
                mysqli_query($db, "DELETE FROM `likes` WHERE `img_id`= $id");
                mysqli_query($db, "DELETE FROM `img_tag` WHERE `img_id`= $id");
                mysqli_query($db, "DELETE FROM `img_edit` WHERE `img_id`= $id");



                /* commit transaction */
                if (!mysqli_commit($db)) {
                    print("Transaction commit failed\n");
                    
                } else {
                    if (!unlink("../".$path)) {  
                        echo ("$path cannot be deleted due to an error");  
                    }  
                    echo "<p> Image deleted</p>";
                }
            } else {
                print "<p>Image id invalid!</p>";
            }
        } else {
            print "<p>No image id given to delete!</p>";
        }
    } else {
        print "<p>You can not delete images unless you are an administrator!</p>";
    }



    ?>
    <button id="upload-con" onclick="window.location.href='../gallery.php';">Continue</button>
</div>