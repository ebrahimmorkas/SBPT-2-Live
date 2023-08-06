<?php
    require "databaseConnect.php";
    // $random = rand(1000,2000);
    // $updateSql = "UPDATE `users` SET `token` = '$random' WHERE (`id` = '1')";
    // $updateResult = mysqli_query($conn, $updateSql);
    session_start();
    // if(isset($_SESSION['login']) == true)
    // {
        $username = $_SESSION['username'];
        $token = $_SESSION['token'];
        $selectSql = "SELECT * FROM `users` WHERE `username`='$username'";
        $selectResult = mysqli_query($conn, $selectSql);
        $row = mysqli_fetch_assoc($selectResult);
        $databaseToken = $row['token'];
        $data['session_token'] = $token;
        $data['database_token'] = $databaseToken;
        if($databaseToken != $token)
        {
            // Single login
            // echo "Single";
            $data['output']='logout';
        }
        else
        {
            // Multiple Login
            // echo "Multiple";
            // session_unset();
            // session_destroy();
            // header("location:login.php");
            $data['output']='login';
        }
        echo json_encode($data);
        // json_encode($data);
    // }
    // else
    // {
    //     // Do nothing
    // }
?>