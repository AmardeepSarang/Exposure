<?php
session_start();
include_once 'include/config.php';
function uploadFile($file)
{
    //upload image to upload folder and return new file path
    $MAX_FILE_SIZE = 5000000;/*b*/

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
            echo $MAX_FILE_SIZE . ">" . $fileSize;
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
if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $path = uploadFile($file);
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $tags = $_POST['tags'];
    //seperate tags
    $tagList = explode(' ', $tags);
    echo "<br>";
    echo $path;
    echo "<br>";
    echo $title;
    echo "<br>";
    echo $desc;
    echo "<br>";
    echo $tags;
    echo "<br>";
    print_r($tagList);

    //insert image
    // Connect to MySQL
    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $is_original=1;
    $user=1;//temp

    $sql = "INSERT INTO `image` (`Img_id`, `title`, `Img_file_name`, `edited_by`, `uploaded_by`, `is_original`, `uploaded_on`, `description`) VALUES (NULL, '$title', '$path', NULL, '$user', '$is_original', current_timestamp(), '$desc')";
    

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
