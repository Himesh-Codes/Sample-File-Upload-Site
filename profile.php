<?php 
/*******Session start********/
session_start();

/*
* This file is part of   Triassicsolutions.Filesite Upload PHP File;
*
* (c) Triassicsolutions PVT LTD
*
* This package is Open Source Software. For the full copyright and license
* information, please view the LICENSE file which was distributed with this
* source code.
*/

    //Check whether logged or not
if (!isset($_SESSION["logstatus"])) 
{
    header("Location:index.php?unauthorised=true");
    exit;
}

  /**
  *Error array to show errors as message
  *
  * @var string 
  */
  $error= array();

  /**
   *Global variable for email status
   *
   * @var string 
   */
   global $status;

  /**
  *Variable to show a success message
  *
  * @var string 
  */
  $success= "";

  /******File checking*********/
  if(isset($_FILES['userfile']))
  {
    /**
     *file name of the uploaded file
     *
     * @var string 
    */
    $fileName = $_FILES['userfile']['name'];


    /**
     *userid of the person
     *
     * @var string 
    */
    $userid = $_SESSION['userid'];

    /**
     *file size of the uploaded file
     *
     * @var string 
    */
    $fileSize = $_FILES['userfile']['size'];

    /**
     *file temporory location name of the uploaded file
     *
     * @var string 
    */
    $fileTmp = $_FILES['userfile']['tmp_name'];

    /**
     *file temporory location name of the uploaded file
     *
     * @var string 
    */
    $fileTmpName = "";

    /**
     *type of the uploaded file
     *
     * @var string 
    */
    $fileType=$_FILES['userfile']['type'];

    /**
     *extension of the uploaded file
     *
     * @var string 
    */
    $ext = explode('.',$_FILES['userfile']['name']);
    $fileExt = strtolower(end($ext));

    /**
     *allowed extensions for uploaded files
     *
     * @var string 
    */
    $extensions= array("jpeg","jpg","png","pdf","docx");

    if(in_array($fileExt,$extensions)=== false){
      $error[]="extension not allowed, please choose a JPEG,JPG,PNG,DOCX or PDF file.";
  }

  /*******Check the size of file*********/
  if($fileSize > 2097152)
  {
     $error[]='File size must be excately 2 MB';
 }

     /********Check the errors**********/
     if(empty($error)==true && isset($_FILES['userfile']))
     {
        //timestamp used as temporary server side folder name
         $fileTmpName = time();

         move_uploaded_file($fileTmp,"uploads/".$fileTmpName.".".$fileExt);

             /**
             *File name or location is saved as a variable to use in database
             *
             * @var string 
             */
             $fileLocation = "uploads/".$fileTmpName.".".$fileExt;

             /***********Database Section********/
             include_once 'database.php';

              //Call the connection function
             dbConnect($servername, $username, $pass, $dbname);

             /*********Query section**********/
             $sql = "INSERT INTO user_files (userid, filename, filesize, filetype, fileextension, filelocation, created_at) VALUES ('$userid', '$fileName', '$fileSize', '$fileType', 
             '$fileExt', '$fileLocation', now())";

             /**
             *Session variable for filename
             *
             * @var string 
             */
              $_SESSION["filename"] = $fileName;

             if ($conn->query($sql) === TRUE) 
             {
              $success = "New file uploaded successfully";
            
              /****** Mail Send If The File Successfully Uploaded **********/
              include 'mailto.php';

              $status = $mailStatus;

              //unset  files sessions for prevent reentry
             header("Location:profile.php");
          } 
          else 
          {
              $error[] = "Error: " . $sql . "<br>" . $conn->error;
          }
            //Call the connection function
          dbClose();
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/third_party/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
    <title>File Upload</title>
</head>
<body>
  <!-- ******File Upload******* -->
  <div class="upload-container">
    <div class="inside-container">
        <div class="logout-container">
        <p class="logout"><a href="index.php?logout=true">LOGOUT</a></p>
        </div>
      <?php 

        if ($_SESSION["userrole"] == 'user') 
        {

        /********Print Session*******/
        echo "<h2 class='alert-success'>Welcome &nbsp".$_SESSION["username"]."!!&nbsp Your userID: &nbsp <i>".$_SESSION["userid"]."</i></h2>"; 

        echo "<h3 class='base-font'>Pick Up Your File To be Uploaded ...</h3>
        <div class='align-container'> 
        <form action='' method='POST' enctype='multipart/form-data'>
        <input type='file' name='userfile'/>
        <input type='submit'/>
        </form>
        </div>";

             /**
              *array length of error variable is found 
              *
              * @var string 
              */
             $arrLength = count($error);

             /******** Print The Errors **********/
             for ($index=0; $index < $arrLength ; $index++) 
             { 
              echo "<p class= 'alert-error'>*".$error[$index]."</p>";
          }

          /*********** Print a success message **********/
          echo "<p class='alert-success'>".$success."&nbsp".$status."</p>";

          include "display.php";
          
        }

        else if ($_SESSION["userrole"] == 'admin') 
        {
            //error exist in delete is checked
            if (isset($_SESSION["error"])) 
            {
                /**
                *array length of error variable is found 
                *
                * @var string 
                */
                $arrLength = count($_SESSION["error"]);

                /******** Print The Errors **********/
                for ($index=0; $index < $arrLength ; $index++) 
                { 
                    echo "<p class= 'alert-error'>*".$_SESSION["error"][$index]."</p>";
                }
            }
             //error exist in delete is checked
            if (isset($_SESSION["success"])) 
            {
                /*********** Print a success message **********/
                echo "<p class='alert-success'>".$_SESSION["success"]."</p>";
            }
            //delete works unset all section
            if (isset($_GET['unauthorised']) ) 
                {
                   unset($_SESSION["error"]);
                   unset($_SESSION["sucess"]);

                }
            echo "<h2 class='alert-success'>Hi &nbsp".$_SESSION["userrole"]."&nbsp".$_SESSION["username"]."!!&nbsp Your userID: &nbsp <i>".$_SESSION["userid"]."</i></h2>";
            echo "<h3 class='base-font'>You have the permission to view or delete all files</h3>";

            include "display.php";
        }
      ?>
    
</div>
</div>
<!-- *******Script Section******* -->
<script src="js/third_party/jquery.min.js"></script>
<script src="js/third_party/popper.min.js"></script>
<script src="js/third_party/bootstrap.min.js"></script>
<script src="js/index.js"></script>
</body>
</html>