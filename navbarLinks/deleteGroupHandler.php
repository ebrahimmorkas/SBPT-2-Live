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

            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                // Not accessed directly
                $groupName = $_GET['id'];
                echo $groupName;

                // Delete column from `links` tables
                $deleteColumnFromLink = "ALTER TABLE `link` DROP COLUMN `$groupName`";
                $deleteColumnFromLinkResult = mysqli_query($conn, $deleteColumnFromLink);

                // Delete column from `groups` tables
                $deleteColumnFromGroups = "ALTER TABLE `groups` DROP COLUMN `$groupName`";
                $deleteColumnFromGroupsResult = mysqli_query($conn, $deleteColumnFromGroups);

                header("location:addGroup.php?deleted=1");
            }
            else
            {
                // Accessed directly
                header("location:addGroup.php");
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