<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        if($_SERVER['REQUEST_METHOD']=="POST") 
        {
        require("../databaseConnect.php");

        // Getting the ITS no of currently logged in Admin
        $currentUser=$_SESSION['username'];

        $selectSql="SELECT * FROM admins WHERE username='$currentUser'";
        $selectResult=mysqli_query($conn, $selectSql);
        // $row=mysqli_fetch_assoc($selectResult);
        $numOfRows = mysqli_num_rows($selectResult);

        // To check whether admin is logged in or not
        if($numOfRows > 0) 
        {
            $username = $_POST['its'];
            $group = $_POST['group'];

            // Check whether user is added or not in users table
            $select = "SELECT * FROM users WHERE username  = '$username'";
            $result = mysqli_query($conn, $select);
            $rows = mysqli_num_rows($result);
            if($rows>0)
            {
                // User is added in 'users' table
                if($group == 'All')
                {
                    // User is by default added
                    header("location:addUser.php?alreadyAdded=1");
                }
                else
                {
                    $selectGroup="SELECT * FROM `groups` WHERE username='$username' AND `$group`='0'";
                    $selectGroupResult = mysqli_query($conn, $selectGroup);
                    $numOfRows = mysqli_num_rows($selectGroupResult);
                    if($numOfRows > 0)
                    {
                        // User is not added in this group 
                        $updateSql = "UPDATE `groups` SET `$group` = '1' WHERE (`username` = '$username')";
                        $updateResult = mysqli_query($conn, $updateSql);
                        header("location:addUser.php?added=1");
                    }
                    else
                    {
                        // User  is already added in specified group
                        header("location:addUser.php?alreadyAdded=1");
                    }
                }
            }
            else
            {
                // User is not added in 'users' table

                // Dont do anything because this form is not meant to add user in users table

                header("location:addUser.php?userNotFound=1");
            }
        }
        else
        {
            // User is not admin
            session_unset();
            session_destroy();
            header("location:../index.php");
        }
    }
    else
    {
        // Accessed Directly
        header("location:addUser.php");
    }
    }
    else
    {
        header("location:../index.php");
    }
?>