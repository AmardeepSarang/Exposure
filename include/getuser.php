<?php
//session_start();

function getSessionUser(){
    //if the session user var is set then return it, othwise go to login page
    if (isset($_SESSION['userId'])) {
        return $_SESSION['userId'];
    } else {
        header("location: login.php");
    }
    

}   
?>