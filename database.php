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
      *Server name which is going to connect with database
      *
      * @var string 
      */
      $servername = "localhost";

      /**
      *User name for database
      *
      * @var string 
      */
      $username = "root";

      /**
      *Password for database
      *
      * @var string 
      */
      $pass = "";

      /**
      *Database name which we are going to connected with
      *
      * @var string 
      */
      $dbname = "site";

      /**
       * Used for connection to database
       *
       * Connecting the database with variables defined
       *
       *Exit if connection not suceeded
       *@param $servername is passed as the server's name used
       *@param $username is passed as the username for the connection
       *@param $pass is passed as the password used in here
       *@param $dbname is passed as the name of database used 
       */

      function dbConnect($servername, $username, $pass, $dbname)
      {
          // Create connection 
          global $conn;

          $conn = new mysqli($servername, $username, $pass, $dbname);
          // Check connection
          if ($conn->connect_error) 
          {
            die("Connection failed: " . $conn->connect_error);
            }
        }

        /**
       * Used for close connection to database
       *
       * 
       *On exiting from database query
       *
       */

        function dbClose()
        {
          //disconnect
          global $conn;

          $conn->close();
        }
?>