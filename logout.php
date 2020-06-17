<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link href="css/style.css" rel="stylesheet">

</head>
<?php
session_start();
?>
<div class="form-box">
    <?php
    session_unset(); 
    session_destroy();
    echo "<p> You have been securely loged out. We hope to see you again on Exposure</p>"
?>
<button id="upload-con" onclick="window.location.href='login.php';">Continue</button>
</div>