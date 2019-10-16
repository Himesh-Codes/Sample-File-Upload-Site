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
         *Variables with details from the form is initially an empty string
         *
         * @var string 
      */
        $userName = $password = '';

        /**
         *Error in the variable details is initially a null string.
         *
         *It is used to display an Error message
         * @var string 
      */
        $error = array();

       /**
         *Error in login flag
         *
         * @var string 
      */
       $fail = '';

       if ($_SERVER["REQUEST_METHOD"] == "POST") 
       {
            /******Username validate*******/
            if (empty($_POST["username"])) 
            {
              $error[] = "username required";
            } 
            else 
            {
              // check if name only contains letters and whitespace
              if (!preg_match("/^[a-zA-Z ]*$/", $_POST["username"])) 
                {
                    $error[] = " Only letters and white space allowed for username";
                }
                else
                {
                    $userName = validate($_POST["username"]);
                }
            }
            /******Password validate******/
            if (empty($_POST["password"])) 
            {
             $error[] = "password required";
            } 
            else 
            {
              // check if password only contains letters, numbers and whitespace
                if (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["password"])) 
                {
                    $error[] = " Only letters ,numbers and white space allowed for password";
                }
                else
                {
                    $password = validate($_POST["password"]);
                }
            }
            /******************Database section******************/

            if(empty($error)==true)
            { 
              include "database.php";

                  //Call the connection function
              dbConnect($servername, $username, $pass, $dbname);

                  // Hashing Function usage on password
              $password = MD5($password);

              /*********Query section**********/
              $sql = "SELECT  id, userrole,emailid FROM user WHERE user.username = '$userName' AND user.password = '$password' ;";
              $result = $conn->query($sql);

              /**** User Id is fetched ****/
              $row = $result->fetch_assoc();

              /*********Login success***********/
              if ($result->num_rows == 1)
              {
                    /**
                    *Session Variables used in the site 
                    *
                    * @var string 
                    */
                    $_SESSION["username"] = $userName;
                    $_SESSION["userid"] = $row["id"];
                    $_SESSION["userrole"] = $row["userrole"];
                    $_SESSION["useremail"] = $row["emailid"];
                    $_SESSION["logstatus"] = "logged";
                    unset($_SESSION["msg"]);

                    header("Location:profile.php");
                    exit;
                }
                /******LOgin fails******/
                else 
                {
                    $fail = "*Login Failed!!please try again....";
                }

                  //Call the connection function
                dbClose();
            }
        }
            /**
           * Used for the validation
           *
           * Validation on the input with remove slashes ,spaces etc.
           *
           * Builtin functions are used for the validation
           *
           * @param $input is passed as the user inputs
           *
           * @return $input
           */
            function validate($input)
            {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);

                return $input;
            }
?>