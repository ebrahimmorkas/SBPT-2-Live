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
                $id = $_GET['id'];
                $selectSql = "SELECT * FROM `users` WHERE `id`='$id'";
                $selectResult = mysqli_query($conn, $selectSql);
                $row = mysqli_fetch_assoc($selectResult);
                $currentUser = $row['username'];

                if($username == $currentUser)
                {
                    // Remove user from admins, groups, users table
                    $deleteSqlFromAdmins = "DELETE FROM `admins` WHERE (`username` = '$currentUser')";
                    $deleteSqlFromAdminsResult = mysqli_query($conn, $deleteSqlFromAdmins);

                    $deleteSqlFromGroups = "DELETE FROM `groups` WHERE (`username` = '$currentUser')";
                    $deleteSqlFromGroupsResult = mysqli_query($conn, $deleteSqlFromGroups);

                    $deleteSqlFromUsers = "DELETE FROM `users` WHERE (`username` = '$currentUser')";
                    $deleteSqlFromUsersResult = mysqli_query($conn, $deleteSqlFromUsers);

                    header("location:users.php?deleted=1");
                }
                else
                {
                    // Remove user from groups, users table
                    $deleteSqlFromGroups = "DELETE FROM `groups` WHERE (`username` = '$currentUser')";
                    $deleteSqlFromGroupsResult = mysqli_query($conn, $deleteSqlFromGroups);

                    $deleteSqlFromUsers = "DELETE FROM `users` WHERE (`username` = '$currentUser')";
                    $deleteSqlFromUsersResult = mysqli_query($conn, $deleteSqlFromUsers);

                    header("location:users.php?deleted=1");
                }
            }
            else
            {
                // Accessed directly
                header("location:users.php");
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