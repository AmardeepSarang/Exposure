<?php
include_once 'include/config.php';
include_once 'include/getuser.php';
session_start();
//check if loged in 
getSessionUser();
//check if this is an original post or an edited image post
$edit_of = -1;
$db = "";
if (isset($_GET['edit_of'])) {
    $edit_of = $_GET['edit_of'];
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
}

function addTitle($db, $edit_of)
{
    //get title of original to fill input (if posting edit of image)
    if ($edit_of != -1) {
        $query = "SELECT * FROM `image` WHERE `Img_id`=$edit_of";

        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        echo "value = '".$row['title']."'";
    } else {
        echo "";
    }
}
function addTags($db, $edit_of)
{
    //get tags of original to fill input (if posting edit of image)
    if ($edit_of != -1) {
        $query = "SELECT tag.tag_name FROM img_tag, tag WHERE img_tag.tag_id=tag.tag_id AND img_tag.img_id=$edit_of";

        $result = mysqli_query($db, $query);
        
        $tag_str="";
        while ($row = mysqli_fetch_assoc($result)) {
            //make a string of tags
            $tag_str =$tag_str. $row["tag_name"]." ";
        }
        echo "value = '".$tag_str."'";
    } else {
        echo "";
    }
}
function addDes($db, $edit_of)
{
    //get description of original to fill input (if posting edit of image)
    if ($edit_of != -1) {
        $query = "SELECT * FROM `image` WHERE `Img_id`=$edit_of";

        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        echo "value = '".$row['description']."'";
    } else {
        echo "";
    }
}

function addBtnTitle($edit_of)
{
    //prints btn text based on if post is origanl or edited img
    if ($edit_of != -1) {
        echo "Post Edited Image";
    } else {
        echo "Post Image";
    }
}

function addParam($db,$edit_of)
{


    //adds extra param to form based on if post is origanl or edited img
    if ($edit_of != -1) {
        $query = "SELECT * FROM `image` WHERE `Img_id`=$edit_of";

        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        echo '<input type="hidden" name="edit_of" value="'.$edit_of.'" />';
        echo '<input type="hidden" name="upload_by" value="'.$row['uploaded_by'].'" />';
    }
}


?>

<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Image</title>
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
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</a></li>
            <li><a href="about.html"><i class="fas fa-question-circle"></i>&nbsp About</a></li>
        </ul>
    </nav>

    <div class="form-box">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="image-preview">
                <img src="images/placeholder_preview.png" alt="">

            </div>
            <div id="titleInput">Title:<input type="text" <?php addTitle($db, $edit_of) ?> name="title" placeholder="Enter title"></div>

            <div>
                Tags (seperate tages by spaces):<br> <input type="text" <?php addTags($db, $edit_of) ?>  name="tags" placeholder="Enter tags (optional)">
            </div>
            <div>
                Description:<input type="text" name="description" <?php addDes($db, $edit_of) ?> placeholder="Enter description (optional)">
            </div>
            <div id="filediv">
                File: <input id="imginput" type="file" name="file">
            </div>
            <?php addParam($db,$edit_of)?>
            <button type="submit" name="submit"><?php addBtnTitle($edit_of)?></button>
        </form>
    </div>
    <script src="js/post.js"></script>
</body>