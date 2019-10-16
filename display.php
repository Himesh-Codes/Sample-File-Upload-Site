<?php 
 //Check whether logged or not
if (!isset($_SESSION["logstatus"])) 
{
    header("Location:index.php?unauthorised=true");
}
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
    <div>
        <div class="display-container">
            <?php 
            //Include the preview check file
            include 'preview.php';

            /******** check the userrole *********/
            if ($_SESSION["userrole"] == 'admin') 
            {
                if ($result->num_rows > 0) 
                {
                    /**
                    *serial number variable
                    *
                    * @var integer 
                    */
                    $no = 0;

                    ?>
                    <!-- table section starts -->
                    <table>

                        <tr>
                            <th>sl.no:</th>
                            <th>Name</th>
                            <th>File</th>
                            <th>Filename</th>
                            <th>Filesize</th>
                            <th>Filetype</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                        <?php
                         // output data of each row
                        while($row = $result->fetch_assoc()) 
                        {   
                            //id of user
                            $id = $row["fileid"];

                            //extension of file
                            $ext = $row["fileextension"];

                            //file location
                            $loc = $row["filelocation"];

                            //increment serial numer
                            $no ++;
                            ?>

                            <!-- ********* Display section ******** -->
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $row["username"] ?></td>
                                <!-- ******** Image section ******** -->
                                <?php
                                 if ($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg' ) 
                                {
                                ?>
                                <td><a href="#"  onclick="window.open('<?php echo $row["filelocation"]?>','name','width=600,height=400')"><img  src='<?php echo $row["filelocation"]?>' alt='loading....'></a></td>
                                <?php 
                                }
                                /******* pdf section ********/
                                else if ($ext == 'pdf') 
                                {
                                ?>
                                 <td><a href="<?php echo $row["filelocation"]?>" download><img  src='assets/pdf.png' alt='loading....'></a></td>
                                <?php 
                                }
                                /****** document section **********/
                                else if ($ext == 'docx') 
                                {
                                ?>
                                 <td><a href="<?php echo $row["filelocation"]?>" download><img  src='assets/docx.png' alt='loading....'></a></td>
                                <?php 
                                }
                                 ?>
                                <td><?php echo $row["filename"] ?></td>
                                <td><?php echo $row["filesize"] ?></td>
                                <td><?php echo $row["fileextension"] ?></td>
                                <td><?php echo $row["created_at"] ?></td>
                                <td><a href='#' onclick = "drop(<?php echo $id ?>, '<?php echo $loc ?>' )">Delete</a></td>
                            </tr>

                            <?php 
                            }
                            ?>
                    </table><br>
                    <?php  
                }
                        else
                        {
                            echo "<p><i>No data to show.....</i></p>";
                        }
                    dbClose();
            }
           if ($_SESSION["userrole"] == 'user')
            {   

                if ($result->num_rows > 0) 
                {
                    /**
                    *serial number variable
                    *
                    * @var integer 
                    */
                    $no = 0;

                    ?>
                    <table>

                        <tr>
                            <th>sl.no:</th>
                            <th>id</th>
                            <th>Filename</th>
                            <th>Filesize</th>
                            <th>Created On</th>
                        </tr>
                        <?php

                    while($row = $result->fetch_assoc()) 
                    {
                        //extension of file
                        $ext = $row["fileextension"];

                        //increment serial numer
                            $no ++;

                            ?>
                             <tr>
                                <td><?php echo $no ?></td>
                                <?php
                        /******** check the file type for display preview **********/
                        if ($ext == 'png' || $ext == 'jpeg' || $ext == 'jpg' ) 
                        {
                            ?>
                            <td><a href="#"  onclick="window.open('<?php echo $row["filelocation"]?>','name','width=600,height=400')"><img  src='<?php echo $row["filelocation"]?>' alt='loading....'></a></td>
                            <td><?php echo $row["filename"]; ?></td>
                            <td><?php echo $row["filesize"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>


                            <?php   
                        }
                        elseif ($ext == 'pdf') 
                        {
                            ?>
                            <td><a href="<?php echo $row["filelocation"]?>" download><img  src='assets/pdf.png' alt='loading....'></a></td>
                            <td><?php echo $row["filename"]; ?></td>
                            <td><?php echo $row["filesize"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>
                            <?php  
                        }
                        elseif ($ext == 'docx') 
                        {
                            ?>
                            <td><a href="<?php echo $row["filelocation"]?>" download><img  src='assets/docx.png' alt='loading....'></a></td>
                            <td><?php echo $row["filename"]; ?></td>
                            <td><?php echo $row["filesize"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>
                            <?php  
                        }
                        ?>
                            </tr>
                        <?php
                    }  
                }
                else
                {
                    echo "<p><i>No data to show.....</i></p>";
                }
                dbClose();
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