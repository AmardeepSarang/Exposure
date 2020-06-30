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



?>
<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User profile</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c4c79ee8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
            <a href="post.php"><i class="fas fa-plus"></i>&nbsp Post new image</a>
        </div>
        <ul class="nav-links">
            <li><a href="gallery.php"><i class="fas fa-th"></i>&nbsp Gallery</a></li>
            <li><a href="user.php"><i class="fas fa-house-user"></i>&nbsp My dashboard</a></li>
            <li><a href="account.html"><i class="fas fa-user-cog"></i></i>&nbsp settings</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</a></li>
            <li><a href="about.html"><i class="fas fa-question-circle"></i>&nbsp About</a></li>
        </ul>
    </nav>

    <!--
        Full screen image div
    -->
    <div class="gal-full-view">
        <button class="fullscreen-close-bt"><i class="far fa-times-circle"></i></button>
        <img src="">
    </div>

    <!--
        Start of page content
    -->
    <div class="user-heading user-welcome">
        <h1>Welcome, <?php getUserName($db, $user) ?>! Take a look at what you have been up to on Exposure</h1>
    </div>
    <div class="user-heading">
        <button type="button" data-toggle="collapse" data-target="#stat-fold"><i class="fas fa-chevron-circle-down"></i></button>

        <h1>Your Exposure Stats</h1>

    </div>

    <div class="fold-con collapse in" id="stat-fold">
        <div class="user-stats">
            <p>Images Uploaded: <b><?php getImgUploaded($db, $user) ?></b></p>
            <p>Images Edited: <b><?php getImgEdited($db, $user) ?></b></p>
            <p>Images Liked: <b><?php getImgLiked($db, $user) ?></b></p>
            <p>Likes On Images <br>You Uploaded: <b><?php getLikeOnUpload($db, $user) ?></b></p>
            <p>Likes On Images <br>You Edited: <b><?php getLikeOnEdited($db, $user) ?></b></p>
        </div>
    </div>


    <div class="user-heading">
        <button type="button" data-toggle="collapse" data-target="#like-fold"><i class="fas fa-chevron-circle-down"></i></button>

        <h1>Images You Liked</h1>

    </div>

    <div class="fold-con collapse in" id="like-fold">
        <div class="grid">
            <!-- columns -->
            <div class="grid-col grid-col--1"></div>
            <div class="grid-col grid-col--2"></div>
            <div class="grid-col grid-col--3"></div>
            <div class="grid-col grid-col--4"></div>
            <?php
            $query = "SELECT * FROM image, likes WHERE image.Img_id=likes.img_id AND likes.user_id=$user";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 0) {
                echo "<h2 class='fold-empty'>This section is empty, try liking some images! </h2>";
            }
            while ($row = mysqli_fetch_assoc($result)) {
                // output data of each row
                //$row = mysqli_fetch_assoc($result);
                $id = $row["Img_id"];
                $path = $row["Img_file_name"];
                $title = $row['title']

            ?>
                <div class="grid-item">
                    <div class="img_box" <?php echo 'data-user= "' . $user . '" data-img= "' . $id . '"' ?>>
                        <div class="img_box_header">
                            <h1><?php echo $title ?></h1>

                        </div>
                        <img src=<?php echo "'" . $path . "'" ?>>
                        <div class="pic-edit-picker">
                            <span><img class="pic-edit-picked" src=<?php echo "'" . $path . "'" . "data-img= '" . $id . "'" . " data-img-title= '" . $title . "'" ?>></span>

                            <?php
                            //returns list of edits of the image
                            $query = "SELECT * FROM img_edit, image WHERE img_edit.img_id=image.Img_id AND img_edit.edit_id=$id";
                            $edit_result = mysqli_query($db, $query);
                            while ($edit_row = mysqli_fetch_assoc($edit_result)) {
                                $edit_id = $edit_row["Img_id"];
                                $edit_title = $edit_row["title"];
                                $edit_path = $edit_row["Img_file_name"];
                                echo '<span><img src="' . $edit_path . '" data-img= "' . $edit_id . '" data-img-title= "' . $edit_title . '"></span>';
                            }
                            ?>

                        </div>
                        <div class="pic-control-bar">
                            <span><?php addLike($db, $user, $id) ?></span>
                            <span><button><i class="fas fa-plus-square"></i></button></span>
                            <span><button class="fullscreen-bt"><i class="fas fa-expand"></i></button></span>
                            <span><button><i class="fas fa-info-circle"></i></button></span>
                            <span><button class="edit-sl-arw-l"><i class="fas fa-arrow-left"></i></button></span>
                            <span><button class="edit-sl-bn"><i class="fas fa-images"></i></button></span>
                            <span><button class="edit-sl-arw-r"><i class="fas fa-arrow-right"></i></button></span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="user-heading">
        <button type="button" data-toggle="collapse" data-target="#edit-fold"><i class="fas fa-chevron-circle-right"></i></button>

        <h1>Images You Edited</h1>

    </div>

    <div class="fold-con collapse" id="edit-fold">
        <div class="grid">
            <!-- columns -->
            <div class="grid-col grid-col--1"></div>
            <div class="grid-col grid-col--2"></div>
            <div class="grid-col grid-col--3"></div>
            <div class="grid-col grid-col--4"></div>
            <?php
            $query = "SELECT * FROM `image` WHERE edited_by=$user";
            $result = mysqli_query($db, $query);

            if (mysqli_num_rows($result) == 0) {
                echo "<h2 class='fold-empty'>This section is empty, try editing some images! </h2>";
            }
            while ($row = mysqli_fetch_assoc($result)) {
                // output data of each row
                //$row = mysqli_fetch_assoc($result);
                $id = $row["Img_id"];
                $path = $row["Img_file_name"];
                $title = $row['title']

            ?>
                <div class="grid-item">
                    <div class="img_box" <?php echo 'data-user= "' . $user . '" data-img= "' . $id . '"' ?>>
                        <div class="img_box_header">
                            <h1><?php echo $title ?></h1>

                        </div>
                        <img src=<?php echo "'" . $path . "'" ?>>
                        <div class="pic-edit-picker">
                            <span><img class="pic-edit-picked" src=<?php echo "'" . $path . "'" . "data-img= '" . $id . "'" . " data-img-title= '" . $title . "'" ?>></span>

                            <?php
                            //returns list of edits of the image
                            $query = "SELECT * FROM img_edit, image WHERE img_edit.img_id=image.Img_id AND img_edit.edit_id=$id";
                            $edit_result = mysqli_query($db, $query);
                            while ($edit_row = mysqli_fetch_assoc($edit_result)) {
                                $edit_id = $edit_row["Img_id"];
                                $edit_title = $edit_row["title"];
                                $edit_path = $edit_row["Img_file_name"];
                                echo '<span><img src="' . $edit_path . '" data-img= "' . $edit_id . '" data-img-title= "' . $edit_title . '"></span>';
                            }
                            ?>

                        </div>
                        <div class="pic-control-bar">
                            <span><?php addLike($db, $user, $id) ?></span>
                            <span><button><i class="fas fa-plus-square"></i></button></span>
                            <span><button class="fullscreen-bt"><i class="fas fa-expand"></i></button></span>
                            <span><button><i class="fas fa-info-circle"></i></button></span>
                            <span><button class="edit-sl-arw-l"><i class="fas fa-arrow-left"></i></button></span>
                            <span><button class="edit-sl-bn"><i class="fas fa-images"></i></button></span>
                            <span><button class="edit-sl-arw-r"><i class="fas fa-arrow-right"></i></button></span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="user-heading">
        <button type="button" data-toggle="collapse" data-target="#upload-fold"><i class="fas fa-chevron-circle-right"></i></button>

        <h1>Images You Uploaded</h1>

    </div>

    <div class="fold-con collapse" id="upload-fold">
        <div class="grid">
            <!-- columns -->
            <div class="grid-col grid-col--1"></div>
            <div class="grid-col grid-col--2"></div>
            <div class="grid-col grid-col--3"></div>
            <div class="grid-col grid-col--4"></div>

            <?php
            $query = "SELECT * FROM `image` WHERE uploaded_by=$user";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 0) {
                echo "<h2 class='fold-empty'>This section is empty, try uploading some images! </h2>";
            }

            while ($row = mysqli_fetch_assoc($result)) {
                // output data of each row
                //$row = mysqli_fetch_assoc($result);
                $id = $row["Img_id"];
                $path = $row["Img_file_name"];
                $title = $row['title']

            ?>
                <div class="grid-item">
                    <div class="img_box" <?php echo 'data-user= "' . $user . '" data-img= "' . $id . '"' ?>>
                        <div class="img_box_header">
                            <h1><?php echo $title ?></h1>

                        </div>
                        <img src=<?php echo "'" . $path . "'" ?>>
                        <div class="pic-edit-picker">
                            <span><img class="pic-edit-picked" src=<?php echo "'" . $path . "'" . "data-img= '" . $id . "'" . " data-img-title= '" . $title . "'" ?>></span>

                            <?php
                            //returns list of edits of the image
                            $query = "SELECT * FROM img_edit, image WHERE img_edit.img_id=image.Img_id AND img_edit.edit_id=$id";
                            $edit_result = mysqli_query($db, $query);
                            while ($edit_row = mysqli_fetch_assoc($edit_result)) {
                                $edit_id = $edit_row["Img_id"];
                                $edit_title = $edit_row["title"];
                                $edit_path = $edit_row["Img_file_name"];
                                echo '<span><img src="' . $edit_path . '" data-img= "' . $edit_id . '" data-img-title= "' . $edit_title . '"></span>';
                            }
                            ?>

                        </div>
                        <div class="pic-control-bar">
                            <span><?php addLike($db, $user, $id) ?></span>
                            <span><button><i class="fas fa-plus-square"></i></button></span>
                            <span><button class="fullscreen-bt"><i class="fas fa-expand"></i></button></span>
                            <span><button><i class="fas fa-info-circle"></i></button></span>
                            <span><button class="edit-sl-arw-l"><i class="fas fa-arrow-left"></i></button></span>
                            <span><button class="edit-sl-bn"><i class="fas fa-images"></i></button></span>
                            <span><button class="edit-sl-arw-r"><i class="fas fa-arrow-right"></i></button></span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <script src="js/user.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/gallery.js"></script>
    <script src="https://unpkg.com/colcade@0/colcade.js"></script>
    <script>
    $('.grid').colcade({
  columns: '.grid-col',
  items: '.grid-item'
})
</script>
</body>