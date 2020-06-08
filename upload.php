<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link href="css/style.css" rel="stylesheet">

</head>
<?php
session_start();
include_once 'include/config.php';
function uploadFile($file)
{
    //upload image to upload folder and return new file path
    $MAX_FILE_SIZE = 10000000;/*b*/

    //print_r($file);
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    //get extention of file ie jpg
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    //check thst uploaded file type is allowed
    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExt, $allowed)) {
        //check for upload error
        if ($fileError === 0) {
            //check file size
            //echo $MAX_FILE_SIZE . ">" . $fileSize;
            if ($fileSize < $MAX_FILE_SIZE) {
                //create uniqe file name using time stamp
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                //create path to folder
                $fileDestination = 'images/uploads/' . $fileNameNew;
                //upload file
                move_uploaded_file($fileTmpName, $fileDestination);
                return $fileDestination;
            } else {
                echo 'Your file is too big';
                return 'error';
            }
        } else {
            echo "There was an error uploading your file";
            return 'error';
        }
    } else {
        echo "You cannot upload file of this type";
        return 'error';
    }
}
function getIdByPath($db, $path)
{
    //get image id using path name
    $query = "SELECT * FROM `image` WHERE Img_file_name = '$path'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        //echo "id: " . $row["Img_id"] . " - path Name: " . $row["Img_file_name"] . "<br>";
        return $row["Img_id"];
    }
}

function getTagIdByname($db, $name)
{
    //get tag id if the tag exits
    $query = "SELECT * FROM `tag` WHERE tag_name = '$name'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result);
        //echo "id: " . $row["tag_id"] . " - Name: " . $row["tag_name"] . "<br>";
        return $row["tag_id"];
    }
    return false;
}

function insertTag($db, $tag)
{
    //inserts new tag and returns id
    //use sanitation
    $query = "INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES (NULL, ?);";
    if ($statement = mysqli_prepare($db, $query)) {

        // bind parameters s - string,
        $result = mysqli_stmt_bind_param($statement, 's', $tag);
        if (!$result) {
            print "<p>bounding error</p>";
        }
        // execute query
        $result = mysqli_stmt_execute($statement);

        if ($result) {
            return getTagIdByname($db, $tag);
        } else {
            print "Mysql insert Error" . mysqli_stmt_error($statement);
        }
    }
}


function insertImgTag($db, $imgId, $tagId)
{
    //inserts img tag relation in img_tag table
    //use sanitation
    $query = "INSERT INTO `img_tag` (`img_id`, `tag_id`) VALUES (?, ?);";
    if ($statement = mysqli_prepare($db, $query)) {

        // bind parameters s - string,
        $result = mysqli_stmt_bind_param($statement, 'ss', $imgId, $tagId);
        if (!$result) {
            print "<p>bounding error</p>";
        }
        // execute query
        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            print "Mysql insert Error" . mysqli_stmt_error($statement);
        }
    }
}

function insertImgedit($db, $imgId, $orgId)
{
    //inserts img edit relation in img_edit table
    //use sanitation
    $query = "INSERT INTO `img_edit` (`img_id`, `edit_id`) VALUES (?, ?);";
    if ($statement = mysqli_prepare($db, $query)) {

        // bind parameters s - string,
        $result = mysqli_stmt_bind_param($statement, 'ss', $imgId, $orgId);
        if (!$result) {
            print "<p>bounding error</p>";
        }
        // execute query
        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            print "Mysql insert Error" . mysqli_stmt_error($statement);
        }
    }
}
?>
<div class="form-box">
    <?php
    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        $path = uploadFile($file);
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $tags = $_POST['tags'];
        //seperate tags
        $tagList = explode(' ', $tags);


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

        //insert imag
        $user = 111;


        $edit_of = -1;
        $is_original = 1;
        $upload_user = $user;
        $edit_user = "NULL";
        if (isset($_POST['edit_of'])) {
            $edit_of = $_POST['edit_of'];
            if (isset($_POST['upload_by'])) {
                $upload_user = $_POST['upload_by'];
                $edit_user = $user;
            }

            $is_original = 0;
        }

        //use sanitation
        $query = "INSERT INTO `image` (`Img_id`, `title`, `Img_file_name`, `edited_by`, `uploaded_by`, `is_original`, `uploaded_on`, `description`) VALUES (NULL, ?, ?, ?, ?, ?, current_timestamp(), ?)";
        if ($statement = mysqli_prepare($db, $query)) {

            // bind parameters s - string,
            $result = mysqli_stmt_bind_param($statement, 'ssssss', $title, $path,$edit_user, $upload_user, $is_original, $desc);
            if (!$result) {
                print "<p>bounding error</p>";
            }
            // execute query
            $result = mysqli_stmt_execute($statement);

            if ($result) {
                print "<p>Your image post was successful</p>";
            } else {
                print "Mysql insert Error" . mysqli_stmt_error($statement);
            }
        }

        $imgId = getIdByPath($db, $path);
        //echo $imgId;

        //for each tag see if it exits in tag table and the link it with img
        foreach ($tagList as $tag) {
            $tag = strtolower($tag);
            $id = getTagIdByname($db, $tag);

            if ($id == false) {
                //no such tag so insert it

                $id = insertTag($db, $tag);
                // echo $id ."(inserted) ".$tag."<br>";
            }/*else{
            echo $id ." ".$tag."<br>";
        }*/

            //insert relation
            insertImgTag($db, $imgId, $id);
        }
        if (isset($_POST['edit_of'])) {
            //set new image to be an edit of old image
            insertImgedit($db, $imgId, $edit_of);
        }
        mysqli_close($db);
    }


    ?>
    <button id="upload-con" onclick="window.location.href='gallery.php';">Continue</button>
</div>