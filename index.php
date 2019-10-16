<?php
/* use anynamespace; here */

/*******Session starts*******/
session_start();

/*
 * This file is part of   Triassicsolutions.FileSite PHP File;
 *
* (c) Triassicsolutions PVT LTD
*
* This package is Open Source Software. For the full copyright and license
* information, please view the LICENSE file which was distributed with this
* source code.
*/
    
    //To make session message for unauthorised entry 
    if (isset($_GET['unauthorised']) ) 
    {
        unset($_SESSION["logstatus"]);
        $_SESSION["msg"] = "unauthorised entry please login to continue"; 
        header("Location:index.php");
        exit;   
    }

    if (isset( $_SESSION["msg"])) 
    {
       session_destroy();
    }
    
    //To make session message for unauthorised entry 
    if (isset($_GET['logout']) ) 
    {
        unset($_SESSION["logstatus"]);
        session_destroy();
        header("Location:index.php");
        exit;   
    }

    //To check if the session is not unset then redirect to profile
    if (isset($_SESSION["logstatus"])) 
    {
        header("Location:profile.php");
        exit;
    }

    //Validate file included
    include 'validate.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/third_party/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
      <!--********** Form Section  **********-->
      <div class="inner-container">
        <div class="login-container">
          <h2 class="base-font login-title">LOGIN</h2>
          <div class="input-area">
            <!-- ***** Form Begins ****** -->
            <form name="form" action="" method="post">
              <!-- *******errorror Section -->
              <div>
                <?php 
                echo "<p class='alert-error'>".$fail."</p>";
                if (isset($_SESSION["msg"])) {
                     echo "<p class='alert-error'>".$_SESSION["msg"]."</p>";
                }               
               
                ?>
                </div>
                <!-- ******** Username Section ********* --> 
                <div class="input-section">
                    <h5 class="input-text">Username</h5>
                    <div class="row">
                        <div class="col-sm-12 col-lg-2">
                            <p class="icon-align"><i class="fa fa-user" aria-hidden="true"></i></p>
                        </div>
                        <div class="col-sm-12 col-lg-10">
                            <input type="text" name="username" class="form-control float-right">
                        </div>
                    </div>
                </div>
                <!-- ******Passsword section****** -->
                <div class="input-section">
                    <h5 class="input-text">Password</h5>
                    <div class="row">
                        <div class="col-sm-12 col-lg-2">
                            <p class="icon-align"><i class="fa fa-unlock-alt" aria-hidden="true"></i></p>
                        </div>
                        <div class="col-sm-12 col-lg-10">
                            <input type="password" name="password" class="form-control float-right">
                            <?php 
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

                              ?>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="#">Not Yet Registered?</a>
                    <button type="submit" class="btn-lg btn-secondary" name="submitId" id="submitId">Submit</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <!--***************SCRIPT***************-->
    <script src="js/third_party/jquery.min.js"></script>
    <script src="js/third_party/popper.min.js"></script>
    <script src="js/third_party/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
    </body>
</html>