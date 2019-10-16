<?php 
/*
 * This file is part of   Triassicsolutions.FileSite PHP File;
 *
* (c) Triassicsolutions PVT LTD
*
* This package is Open Source Software. For the full copyright and license
* information, please view the LICENSE file which was distributed with this
* source code.
*/

 /**
  * file name of the user that has entered
  *
  * @var string 
  */
 $name = $_SESSION["filename"];

    /**
  * file name of the user that has entered
  *
  * @var string 
  */
    $mailStatus = "";

  /**
  *Subject of mail message to user
  *
  * @var string 
  */
  $subject = "Your File Upload Status";

  /**
  *the mail message to user
  *
  * @var string 
  */
  $message = "The File ".$name."  is uploaded successfully";

  /**
  * mail of user
  *
  * @var string 
  */
  $mailTo = $_SESSION["useremail"];

   /**
   * Used for mail to user 
   *
   *after upload a file user get mail through the function
   *
   *SMTP used
   *@param $servername is passed as the server's name used
   *@param $username is passed as the username for the connection
   *@param $pass is passed as the password used in here
   *@param $dbname is passed as the name of database used 
   */   
   $feedback = mail("$mailTo","$subject", "$message");

   /****** check the mail delivered successfully **********/
   if ($feedback == true) 
   {
      $mailStatus = "Check the mail for details.....";
      
  }

  else
  {
     $mailStatus = "Something Went Wrong On mail....";
    
 }
 ?>