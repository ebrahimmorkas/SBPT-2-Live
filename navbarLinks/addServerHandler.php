<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        require("../databaseConnect.php");
        // Fetching the ITS of currently logged in user
        $username=$_SESSION['username'];
        $selectSql="SELECT * FROM admins WHERE username='$username'";
        $selectResult=mysqli_query($conn,$selectSql);
        $numOfRows = mysqli_num_rows($selectResult);
        if($numOfRows > 0) 
        {
            // Admin 
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $serverName = $_POST['serverName'];
                $choice = $_POST['choice'];
                if($serverName == "")
                {
                    // Empty
                    header("location:servers.php?empty=1");
                }
                else
                {
                    // Not empty
                    $alreadyExists = 0;

                    $select = "SELECT * FROM servers WHERE name='$serverName'";
                    $result = mysqli_query($conn, $select);
                    $rows = mysqli_num_rows($result);
                    if($rows>0)
                    {
                        $alreadyExists = 1;
                    }
                    else
                    {
                        $alreadyExists = 0;
                    }
                    if(!$alreadyExists)
                    {
                        // Server Name does not exists
                        // Add server into database
                            
                        // Creating the variables that will hold 0 or 1 if value of choice will be audio and video then it will hold 1 else 0 
                        $audioAndVideo = '1';
                        $onlyAudio = '0';
                        if($choice == "video")
                        {
                            $audioAndVideo = '1';
                            $onlyAudio = '0';
                        }
                        else
                        {
                            $audioAndVideo = '0';
                            $onlyAudio = '1';
                        }
                        $insertSql = "INSERT INTO `servers` (`name`, `video`, `audio`) VALUES ('$serverName', '$audioAndVideo', '$onlyAudio')";
                        $insertResult = mysqli_query($conn, $insertSql);

                        $createRowSql = "ALTER TABLE `link` ADD COLUMN `$serverName` VARCHAR(150) NULL DEFAULT ''";
                        $createRowSqlResult = mysqli_query($conn, $createRowSql);

                        header("location:servers.php?added=1");
                    }
                    else
                    {
                        // Server name Exists
                        header("location:servers.php?serverNameAlreadyExists=1");
                    }
                }
            }
            else
            {
                // Accessed Directly
                header("location:servers.php");
            }
        }
        else
        {
            // Not admin
            session_unset();
            session_destroy();
            header("location:../index.php");
        }
    }
    else
    {
        header("location:../index.php?login=1");
    }
?>