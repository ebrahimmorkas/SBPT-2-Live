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
            }
            else
            {
                // Accessed directly
                header("location:makeAdmin.php");
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