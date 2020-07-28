<!DOCTYPE html>
<html lan="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Editor Page </title>
    <link href="css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/57c4c79ee8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital@1&display=swap" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/caman.full.min.js"></script>
    <?php
    if (isset($_GET['id']) && isset($_GET['path'])) {
        $id = $_GET['id'];
        $path = $_GET['path'];
    } else {
        echo "paramerters have not been set";
        exit();
    }
    ?>
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
            <a href="<?php echo $path ?>" download> &nbsp <i class="fas fa-plus"></i>&nbsp Download Image &nbsp</a>
            &nbsp &nbsp &nbsp
            <a id="edit-up" href="#"> &nbsp <i class="fas fa-plus"></i>&nbsp Upload &nbsp</a>
            &nbsp &nbsp &nbsp
            <a href="#"> &nbsp <i class="fas fa-plus"></i>&nbsp Submit edited image &nbsp</a>
        </div>
        <ul class="nav-links">
            <li><a href="gallery.php"><i class="fas fa-th"></i>&nbsp Gallery</a></li>
            <li><a href="user.php"><i class="fas fa-house-user"></i>&nbsp My dashboard</a></li>
            <li><a href="account.php"><i class="fas fa-user-cog"></i></i>&nbsp settings</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp Sign out</a></li>
            <li><a href="about.html"><i class="fas fa-question-circle"></i>&nbsp About</a></li>
        </ul>


    </nav>

    <div class="upload-popup">
        <input id="imageLoader" type="file"><br>
        <button id='up-can'>Cancel</button>

        <button id="up-ok">Ok</button>

    </div>
    <div class="editor">
        <div class="filter">
            <h2> Filter </h2>
            <ul>
                <li><a id="filter-vin"> Vintage </a></li>
                <li><a id="filter-sun">Sunrise </a> </li>
                <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> CrossProcess </li>
                <li><a href="#"><i class="fa fa-user-times" aria-hidden="true"></i> Orange </a> </li>
            </ul>
        </div>
        <div class="display">
            <div class="inner">
                <canvas id="editor-can"></canvas>
            </div>
        </div>
        <div class="edit">
            <h2> Editor </h2>

            <h3> Exposure </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="slide-exp">
            </div>

            <h3> Saturation </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="slide-sat">
            </div>

            <h3> Tint </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="slide-hue">
            </div>

            <h3> Contrast </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="slide-cont">
            </div>

            <h3> Sharpness </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="myRange">
            </div>

            <h3> Grain </h3>
            <div class="slidecontainer">
                <input type="range" min="-100" max="100" value="0" class="slider" id="slide-noise">
            </div>

            <h3> Texture And Clarity </h3>
            <div class="slidecontainer">
                <input type="range" min="0" max="100" value="50" class="slider" id="myRange">
            </div>


        </div>
    </div>

    <script src="js/nav.js"></script>
    <script src="js/editor.js"></script>
    <!--
    <script>
        importImg(<?php /*echo '"'.$path.'"'*/ ?>)
    </script>
-->
</body>