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


    /**
    *Session Variables used in the site 
    *
    * @var string 
    */
    $result = '';

    /***********Database Section********/
    include_once 'database.php';

        //Call the connection function
    dbConnect($servername, $username, $pass, $dbname);


    if ($_SESSION["userrole"] == 'admin') 
    {

        /*********Query section**********/
        $sql = "SELECT username,user_files.id AS fileid,filename,filesize,fileextension,filelocation,created_at FROM user_files JOIN user ON user.id=user_files.userid ";
        $result = $conn->query($sql);

    }
    if ($_SESSION["userrole"] == 'user') 
    {   
        /**
        *User id of current user 
        *
        * @var string 
        */
        $id = $_SESSION["userid"] ;

        /*********Query section**********/
        $sql = "SELECT user_files.id AS fileid,filename,filesize,fileextension,filelocation,created_at FROM user_files JOIN user ON user.id=user_files.userid WHERE user_files.userid = '$id' ";
        $result = $conn->query($sql);

    }

    ?>    