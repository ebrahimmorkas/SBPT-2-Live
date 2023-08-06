<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            require "../databaseConnect.php";
            $username = $_SESSION['username'];
            $selectAdmin = "SELECT * FROM `admins` WHERE `username` = '$username'";
            $selectAdminResult = mysqli_query($conn, $selectAdmin);
            $numOfRows = mysqli_num_rows($selectAdminResult);
            if($numOfRows > 0)
            {
                // Admin is logged in 
                $id = $_GET['id'];
                $_SESSION['server'] = $id;
                header("location:home.php");
            }
            else
            {
                // Admin is not logged in
                session_unset();
                session_destroy();
                header("location:../index.php");
            }
        }
        else
        {
            // Accessed Directly
            header("location:home.php?noId=1");
        }
    }
    else
    {
        header("location:../index.php");
    }
?>