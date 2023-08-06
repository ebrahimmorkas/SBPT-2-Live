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
                $password = $_POST['password'];
                $id = $_POST['id'];

                if($password ==  "")
                {
                    // Empty
                    header("location:users.php?empty=1");
                }
                else
                {
                    // Not empty
                    $hashPassword = password_hash($password,PASSWORD_DEFAULT);
                    $updateSql = "UPDATE `users` SET `password` = '$hashPassword' WHERE (`id` = '$id')";
                    $updateSqlResult = mysqli_query($conn, $updateSql);

                    header("location:users.php?changed=1");
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