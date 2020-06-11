<?php
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

$insert=$_POST['insert'];
$user=$_POST['user'];
$img=$_POST['img'];

//toggle insert/delete
if ($insert==1) {
    $sql = "INSERT INTO `likes` (`user_id`, `img_id`) VALUES ('$user', '$img')";
	if (mysqli_query($db, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
}else if ($insert==2){
	//use for checking if like exists
	$sql = "SELECT * FROM `likes` WHERE user_id=$user AND img_id=$img";
	$result=mysqli_query($db, $sql);
	if (mysqli_num_rows($result) > 0) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
} else{
    $sql = "DELETE FROM `likes` WHERE `likes`.`user_id` = '$user' AND `likes`.`img_id` = '$img'";
	if (mysqli_query($db, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
}
?>