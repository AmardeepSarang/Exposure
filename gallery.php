<?php
session_start();
include_once 'include/config.php';
////////////////////////////////////////////////
//functions to save search bar state on reload 
///////////////////////////////////////////////
function addOrderOp()
{
    //add select option selection on reload, keep right option selected
    if (isset($_GET['order'])) {
        $order = $_GET['order'];
        if (strcmp($order, "ascend") == 0) {
            echo '<option value="ascend" selected >Ascending order</option>';
            echo '<option value="descend" >Descending order</option>';
        } else {

            echo '<option value="ascend" >Ascending order</option>';
            echo '<option value="descend" selected>Descending order</option>';
        }
    } else {
        //defalt sql order in desending order
        echo '<option value="ascend" >Ascending order</option>';
        echo '<option value="descend" selected>Descending order</option>';
    }
}
function addSortOp()
{
    //add select option selection on reload, keep right option selected
    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        if (strcmp($sort, "alpha") == 0) {
            echo '<option value="alpha" selected>Alphabetically</option>';
            echo '<option value="date">Date Added</option>';
            echo '<option value="likes"># of Likes</option>';
            echo '<option value="edits"># of Edits</option>';
        } else if (strcmp($sort, "likes") == 0) {
            echo '<option value="alpha">Alphabetically</option>';
            echo '<option value="date" >Date Added</option>';
            echo '<option value="likes" selected ># of Likes</option>';
            echo '<option value="edits"># of Edits</option>';
        } else if (strcmp($sort, "edits") == 0) {
            echo '<option value="alpha">Alphabetically</option>';
            echo '<option value="date" >Date Added</option>';
            echo '<option value="likes"># of Likes</option>';
            echo '<option value="edits" selected ># of Edits</option>';
        } else {
            //select date by default
            echo '<option value="alpha">Alphabetically</option>';
            echo '<option value="date" selected >Date Added</option>';
            echo '<option value="likes"># of Likes</option>';
            echo '<option value="edits"># of Edits</option>';
        }
    } else {
        //defalt sql order by
        echo '<option value="alpha">Alphabetically</option>';
        echo '<option value="date" selected >Date Added</option>';
        echo '<option value="likes"># of Likes</option>';
        echo '<option value="edits"># of Edits</option>';
    }
}
function addSearch()
{
    //adds baack search on reload
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        echo ' value="' . $search . '" ';
    }
}

function genSQL()
{
    //create sql code based on GET parametters
    $sql = "";
    $selectSQL = "";
    $whereSQL = "WHERE is_original = 1";
    $sortSQL = "";
    $orderSQL = "";
    $fromSQL = "";
    $isLikeSearch = false;
    if (isset($_GET['sort'])) {
        //create the first section of the sql based on what to sort by
        $sort = $_GET['sort'];
        if (strcmp($sort, "alpha") == 0) {
            $selectSQL = "SELECT *";
            $fromSQL = "FROM `image`";
            $orderSQL = "ORDER BY title";
        } else if (strcmp($sort, "likes") == 0) {
            $isLikeSearch = true;
            $selectSQL = "SELECT image.`Img_id`,`title`,`Img_file_name`, (SELECT COUNT(*) FROM likes WHERE image.Img_id=likes.img_id) AS like_count";
            $fromSQL = "FROM `image`";
            $orderSQL = "ORDER BY `like_count`";
        } else if (strcmp($sort, "edits") == 0) {
            //do later
        } else {
            //select date by default
            $selectSQL = "SELECT *";
            $fromSQL = "FROM `image`";
            $orderSQL = "ORDER BY uploaded_on";
        }
    } else {
        //defalt sql order by
        $selectSQL = "SELECT *";
        $fromSQL = "FROM `image`";
        $orderSQL = "ORDER BY uploaded_on";;
    }


    //insert search into querry
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        if ($search[0] == "#") {
            //handle tag search
            $tag = substr($search, 1);
            if (!$isLikeSearch) {
                $selectSQL = "SELECT image.`Img_id`,`title`,`Img_file_name`";
            }
            $fromSQL = "FROM image, tag, img_tag";

            $whereSQL = $whereSQL . ' AND image.Img_id=img_tag.img_id AND img_tag.tag_id=tag.tag_id AND LOWER(tag.tag_name)=LOWER("' . $tag . '")';
        } else {
            //add search to querey
            $whereSQL = $whereSQL . " AND LOWER(title) LIKE LOWER('%" . $search . "%')";
        }
    }
    $isLikeSearch = false;

    $sortSQL = "";
    if (isset($_GET['order'])) {
        //select sort order
        $order = $_GET['order'];
        if (strcmp($order, "ascend") == 0) {
            $sortSQL = " ASC";
        } else {
            //defalt sql order in desending order
            $sortSQL = " DESC";
        }
    } else {
        //defalt sql order in desending order
        $sortSQL = " DESC";
    }
    $sql = $selectSQL . " " . $fromSQL . " " . $whereSQL . " " . $orderSQL . " " . $sortSQL;
    echo $sql;
    return $sql;
}

function addLike($db, $user, $id)
{
    //check if a user is loged in

    //add correct like button based on if pic has been liked
    $query = "SELECT * FROM `likes` WHERE `user_id` = $user AND `img_id` = $id";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        echo '<button class="like-bt like-color"><i class="fas fa-star"></i></button>';
    } else {
        echo '<button class="like-bt"><i class="far fa-star"></i></button>';
    }
}

//get user (temp just set it)
$user = 111;


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

//get images from db
$query = genSQL();
$result = mysqli_query($db, $query);


?>
<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c4c79ee8.js" crossorigin="anonymous"></script>

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
            <a href="post.html"><i class="fas fa-plus"></i>&nbsp Post new image</a>
        </div>
        <ul class="nav-links">
            <li><a href="#"><i class="fas fa-th"></i>&nbsp Gallery</a></li>
            <li><a href="#"><i class="fas fa-house-user"></i>&nbsp My dashboard</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</a></li>
            <li><a href="#"><i class="fas fa-question-circle"></i>&nbsp About</a></li>
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
        Gallery nav bar
    -->

    <nav class="gal-nav">

        <div id="gal-search" >
            <input type="text" <?php addSearch() ?> name="gal-search" placeholder="Search title or start with # to search tag">
            <div class="button-holder">
                <button id='gal-clear-bt'><i class="fas fa-times"></i></button>
                <button id='gal-search-bt'><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div id="gal-sort">
            Sort:
            <select class="gal-contr" name="sort">
                <?php addSortOp() ?>
            </select>
            In
            <select class="gal-contr" name="order">
                <?php addOrderOp() ?>
            </select>
        </div>

    </nav>

    <!--
        Gallery 
    -->
    <div class="gallery_container">
        <?php

        while ($row = mysqli_fetch_assoc($result)) {
            // output data of each row
            //$row = mysqli_fetch_assoc($result);
            $id = $row["Img_id"];
            $path = $row["Img_file_name"];
            //echo "id: " . $row["Img_id"] . " - path Name: " . $row["Img_file_name"] . "<br>";

        ?>
            <div class="img_box" <?php echo'data-user= "' . $user . '" data-img= "' . $id .'"'?>>
                <img src=<?php echo "'" . $path . "'" ?>>
                <div class="pic-edit-picker">
                    <span><img class="pic-edit-picked" src=<?php echo "'" . $path . "'" ?>></span>
                    <span><img src="/images/img1-edits/img (1)-a.jpg"></span>


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

        <?php } ?>

    </div>
    <script src="js/nav.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/gallery.js"></script>

</body>