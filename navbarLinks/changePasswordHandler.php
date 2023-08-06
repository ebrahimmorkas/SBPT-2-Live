<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            // Getting the ITS of the currently logged in user
            $ITS=$_SESSION['username'];
            require("../databaseConnect.php");
            $password=$_POST['password'];
            $hashPassword=password_hash($password,PASSWORD_DEFAULT);
            $updateSql="UPDATE `users` SET `password` = '$hashPassword' WHERE (`username` = '$ITS')";
            $updateResult=mysqli_query($conn,$updateSql);

            header("location:changePassword.php?changed=1");
        }
        else
        {
            header("location:changePassword.php");
        }
    }
    else
    {
        header("location:../index.php");
    }
?>