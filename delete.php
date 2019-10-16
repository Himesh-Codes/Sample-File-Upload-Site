<?php 
/*
* This file is part of   Triassicsolutions.Filesite PHP File;
*
* (c) Triassicsolutions PVT LTD
*
* This package is Open Source Software. For the full copyright and license
* information, please view the LICENSE file which was distributed with this
* source code.
*/
/*******Session start********/
    session_start();

 //Check whether logged or not
if (!isset($_SESSION["logstatus"])) 
{
    header("Location:index.php?unauthorised=true");
}

//Check whether admin or not
if (($_SESSION["userrole"]) != 'admin') 
{
    header("Location:index.php?unauthorised=true");
}

    /**
    *variable for id of file
    *
    * @var string 
    */  
    $id = $_GET["valueone"];

    /**
    *variable for success message
    *
    * @var string 
    */  
    $_SESSION["success"]  = "";

    /**
    *variable for error message
    *
    * @var string 
    */  
    $_SESSION["error"] = array();

    /**
    *variable for location of file
    *
    * @var string 
    */  
    $loc = $_GET["valuetwo"];


    /***********Database Section********/
    include 'database.php';

    //Call the connection function
    dbConnect($servername, $username, $pass, $dbname);

    /*********Query section**********/
    $sql = "DELETE FROM user_files WHERE id= '$id'";

    if ($conn->query($sql) === TRUE) 
    {
      if  (unlink('./' . $loc))
      {
       $_SESSION["success"]  = "Your file is deleted permanently";
   }
   else
   {
    $_SESSION["error"] []  = "Problem in deleting file...";
    }
    }
    else 
    {
        $_SESSION["error"] []= "Database updation failed..";
    }
    dbClose();
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/third_party/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/display.css">
    <title>File Upload</title>
</head>
<body>
    <?php

        header( "Location:profile.php?unauthorised=true"); 

        ?>
        
        <!-- *******Script Section******* -->
        <script src="js/third_party/jquery.min.js"></script>
        <script src="js/third_party/popper.min.js"></script>
        <script src="js/third_party/bootstrap.min.js"></script>
        <script src="js/index.js"></script>
</body>
</html>