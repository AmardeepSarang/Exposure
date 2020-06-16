<?php

?>
<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c4c79ee8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
</head>

<body>
    <div class="form-box">
        <form action="sign_in.php" method="POST" enctype="multipart/form-data">
            <div class="image-preview">
                <img src="images/logo.png" alt="">

            </div>
            <div>
                <h1>Welcome back to Exposure!</h1>
            </div>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'noUser') {
                if (isset($_GET['email']) && $_GET['email']) {
            ?>

                    <div class="error-red">
                        Email (ERROR: Email dose not match a user):<br> <input type="text" name="email" value='<?php echo $_GET['email']; ?>' placeholder="Enter email">
                    </div>
                <?php
                } else {
                ?>

                    <div class="error-red">
                        Email (ERROR: Email dose not match a user): <br> <input type="text" name="email" placeholder="Enter email">
                    </div>
                <?php

                }
            } else {
                if (isset($_GET['email']) && $_GET['email']) {
                ?>

                    <div>
                        Email:<br> <input type="text" name="email" value='<?php echo $_GET['email']; ?>' placeholder="Enter email">
                    </div>
                <?php
                } else {
                ?>

                    <div>
                        Email:<br> <input type="text" name="email" placeholder="Enter email">
                    </div>
            <?php

                }
            }
            ?>

            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'noPassMatch') {
                ?>
                <div  class="error-red">
                Password (ERROR incorrect password.):<input type="password" name="password" placeholder="Enter Password">
            </div>

            <?php
            } else {
                ?>
                <div>
                Password:<input type="password" name="password" placeholder="Enter Password">
            </div>

            <?php
            }
            ?>
            <button type="submit" name="log-in-submit">Log in</button>

        </form>
        <button onclick="window.location.href='signup.html'">Sign up</button>
    </div>
</body>