<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        require "../databaseConnect.php";
        $its=$_SESSION['username'];
        $selectSql = "SELECT * FROM admins WHERE username='$its'";
        $selectResult = mysqli_query($conn, $selectSql);
        $numOfRows = mysqli_num_rows($selectResult);
        if($numOfRows>0)
        {
            // Admin logged in
            if(isset($_POST['updateGroup']))
            {
                // Getting the group from dropdown
                $group = $_POST['group'];
                $fileName = $_FILES["excel1"]["name"];
                $fileExtension = explode('.', $fileName);
                $fileExtension = strtolower(end($fileExtension));
                $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
    
                $targetDirectory = "uploads/" . $newFileName;
                move_uploaded_file($_FILES['excel1']['tmp_name'], $targetDirectory);
    
                // $targetDirectory = "/uploads/"
    
                error_reporting(0);
                ini_set('display_errors', 0);
    
                require 'excelReader/excel_reader2.php';
                require 'excelReader/SpreadsheetReader.php';
    
                $reader = new SpreadsheetReader($targetDirectory);
                foreach($reader as $key => $row){
                    // $name = $row[0];
                    // $age = $row[1];
                    // $country = $row[2];

                    $username = $row[0];
                    // $password = $row[1];
                    // $name = $row[2];

                    // Checking that username exits or not in users table
                    $select_sql = "SELECT * FROM users WHERE username='$username'";
                    $selectResult = mysqli_query($conn, $select_sql);
                    $numOfRows = mysqli_num_rows($selectResult);
                    if($numOfRows > 0)
                    {
                        // Username exists

                        // update the group
                        if($group == 'All')
                        {
                            // Add user only in 'All' group

                            // Do nothing because user is by default added in 'All' group
                        }
                        else
                        {
                            // Add user in some other group 
                            $updateSql = "UPDATE `groups` SET `$group` = '1' WHERE (`username` = '$username')";
                            $updateResult  = mysqli_query($conn, $updateSql);
                            header("location:addUser.php?added=1");
                        }
                    }
                    else
                    {
                        // Username does not exists in 'users' table so do nothing beacause this file is not meant to add user in 'users' table.
                        // header("location:addUser.php?notExist=1");
                     }
                }
            }
            else
            {
                // Accessed directly
                header("location:addUser.php");
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