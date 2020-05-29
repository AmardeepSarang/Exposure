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

//get images from db
$query = "SELECT * FROM `image` WHERE is_original = 1 ";
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

        <div id="gal-search">
            <input type="text" name="gal-search" placeholder="Search">
            <div class="button-holder">
                <button><i class="fas fa-times"></i></button>
                <button id='gal-search-bt'><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div id="gal-sort">
            Sort:
            <select class="gal-contr" name="sort">
                <option value="alpha" selected>Alphabetically</option>
                <option value="date">Date Added</option>
                <option value="likes"># of Likes</option>
                <option value="edits"># of Edits</option>
            </select>
            In
            <select class="gal-contr" name="order">
                <option value="ascend" selected>Ascending order</option>
                <option value="descend">Descending order</option>
            </select>
        </div>

    </nav>

     <!--
        Gallery 
    -->
    <div class="gallery_container">
        <?php
            
            while($row = mysqli_fetch_assoc($result)) {
                // output data of each row
                //$row = mysqli_fetch_assoc($result);
                $id=$row["Img_id"];
                $path=$row["Img_file_name"];
                //echo "id: " . $row["Img_id"] . " - path Name: " . $row["Img_file_name"] . "<br>";
                
        ?>
        <div class="img_box">
            <img src=<?php echo "'". $path. "'"?>>
            <div class="pic-edit-picker">
                <span><img class="pic-edit-picked" src=<?php echo "'". $path. "'"?>></span>
                <span><img src="/images/img1-edits/img (1)-a.jpg"></span>
                
            
            </div>
            <div class="pic-control-bar">
                <span><button><i class="fas fa-thumbs-up"></i></button></span>
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