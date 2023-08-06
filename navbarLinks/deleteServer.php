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
                $selectSql = "SELECT * FROM `servers` WHERE `id`='$id'";
                $selectResult = mysqli_query($conn, $selectSql);
                $row = mysqli_fetch_assoc($selectResult);
                $column = $row['name'];

                // Delete column from `links` tables
                $deleteColumn = "ALTER TABLE `link` DROP COLUMN `$column`";
                $deleteColumnResult = mysqli_query($conn, $deleteColumn);

                // Delete from `servers` table
                $deleteSql = "DELETE FROM `servers` WHERE (`id` = '$id')";
                $deleteResult = mysqli_query($conn, $deleteSql);
                header("location:servers.php?deleted=1");
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