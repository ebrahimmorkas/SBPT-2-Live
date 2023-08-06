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

                // Check whether GET request is set
                if(isset($_GET['id']))
                {
                    // Each step followed write your code here

                    $groupNamePost = $_POST['group'];
                    $groupNameGet= $_GET['id'];

                    $updateGroup = "ALTER TABLE `groups` CHANGE COLUMN `$groupNameGet` `$groupNamePost` VARCHAR(45) NULL DEFAULT '0'";
                    $updateGroupResult = mysqli_query($conn, $updateGroup);

                    $updateLink = "ALTER TABLE `link` CHANGE COLUMN `$groupNameGet` `$groupNamePost` VARCHAR(45) NULL DEFAULT '0'";
                    $updateLinkResult = mysqli_query($conn, $updateLink);

                    header("location:addGroup.php?updated=1");
                }
                else
                {
                    // Someone tried to break in
                    header("location:addGroup.php");
                }
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
        header("location:../index.php?login=1");
    }
?>