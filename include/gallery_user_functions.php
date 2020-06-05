<?php

//////////////////////////////////////////////////
//gallery functions
//////////////////////////////////////////////////
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

//////////////////////////////////////////////////
//user functions
//////////////////////////////////////////////////
function getUserName($db,$user){
    $query = "SELECT * FROM `user` WHERE user_id=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["name"];
}
function getImgUploaded($db, $user)
{
    //prints out the # images uploaded by the user
    $query = "SELECT COUNT(*) as count FROM `image` WHERE uploaded_by=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["count"];
}

function getImgEdited($db, $user)
{
    //prints out the # images edited by the user
    $query = "SELECT COUNT(*) as count FROM `image` WHERE edited_by=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["count"];
}
function getImgLiked($db, $user)
{
    //prints out the # images liked by the user
    $query = "SELECT COUNT(*) as count FROM likes WHERE user_id=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["count"];
}

function getLikeOnUpload($db, $user)
{
    //prints out the # images liked by the user
    $query = "SELECT COUNT(*) as count FROM image, likes WHERE image.Img_id=likes.img_id AND image.uploaded_by=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["count"];
}

function getLikeOnEdited($db, $user)
{
    //prints out the # images liked by the user
    $query = "SELECT COUNT(*) as count FROM image, likes WHERE image.Img_id=likes.img_id AND image.edited_by=$user";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row["count"];
}

?>