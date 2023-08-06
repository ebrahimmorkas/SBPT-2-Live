<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        require "../databaseConnect.php";
        // Check for admin
        $username = $_SESSION['username'];
        $selectSql = "SELECT * FROM `admins` WHERE `username`='$username'";
        $selectResult = mysqli_query($conn, $selectSql);
        $numOfRows = mysqli_num_rows($selectResult);
        if($numOfRows > 0)
        {
            // Admin logged in

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                // Not accessed directly
                $id = $_POST['id'];
                $serverName = $_POST['serverName'];
                $choice = $_POST['choice'];

                if($serverName == "")
                {
                    // Server name field empty
                    header("location:servers.php?empty=1");
                }
                else
                {
                    // Server name field not empty

                    // Refer addServerHandler for these variables
                    $audioAndVideo = '1';
                    $onlyAudio = '0';
                    if($choice == "video")
                    {
                        // Do nothing
                    }
                    else
                    {
                        $audioAndVideo = '0';
                        $onlyAudio = '1';
                    }

                    $selectServerName = "SELECT * FROM `servers` WHERE `id`='$id'";
                    $selectServerNameResult =mysqli_query($conn, $selectServerName);
                    $row = mysqli_fetch_assoc($selectServerNameResult);

                    // Getting server name
                    $sName = $row['name'];

                    $updateSql = "UPDATE `servers` SET `name` = '$serverName', `video` = '$audioAndVideo', `audio` = '$onlyAudio' WHERE (`id` = '$id')";
                    $updateResult = mysqli_query($conn, $updateSql);

                    $updateLinkTable = "ALTER TABLE `link` 
                    CHANGE COLUMN `$sName` `$serverName` VARCHAR(45) NULL DEFAULT ''";
                    $updateLinkTableResult = mysqli_query($conn, $updateLinkTable);
                    
                    header("location:servers.php?updated=1");
                }
            }
            else
            {
                // Accessed directly
                header("location:servers.php");
            }
        }
        else
        {
            // Admin not logged in
            session_unset();
            session_destroy();
            header("location:../index.php");
        }
    }
    else
    {
        header("location:../index.php");
    }
?>