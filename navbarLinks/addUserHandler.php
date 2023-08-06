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
            $selectResult=mysqli_query($conn,$selectSql);
            // $row=mysqli_fetch_assoc($selectResult);
            $numOfRows = mysqli_num_rows($selectResult);

            // To check whether admin is logged in or not
            if($numOfRows > 0)
            {
                // Fetching the values from the form
                $name=$_POST['name'];
                $ITS=$_POST['its'];
                $password=$_POST['password'];
                $group=$_POST['group'];

                // Checking whether the enetered ITS exists or not
                $selectSql1="SELECT * FROM users WHERE username='$ITS'";
                $selectResult1=mysqli_query($conn,$selectSql1);
                $numOfRows1=mysqli_num_rows($selectResult1);
                if($numOfRows1)
                {
                    // ITS exists in 'users' table

                    // Check whether 'group'variable = 'All' if so then redirect to addUser.php and throw the message and if not add user in 'groups' table with specified group
                    if($group == 'All') 
                    {
                        // Redirrect user no need to add
                        header("location:addUser.php?ITSExists=1");
                    }
                    else
                    {
                        // Add user in specified group

                        // Check whether user is added in group selected in addUser.php
                        $selectGroup = "SELECT * FROM groups WHERE username = '$ITS' AND $group='1'";
                        $selectGroupResult = mysqli_query($conn, $selectGroup);
                        $numberOfRows = mysqli_num_rows($selectGroupResult);
                        if($numberOfRows == 1)
                        {
                            // User is added in the specified group and throw the message
                            header("location:addUser.php?added=1");
                        }
                        else
                        {
                            // User is not added in group All
                            $insertGroup = "INSERT INTO `groups` (`username`,`$group`) VALUES ('$ITS','$1')";
                            $insertGroupResult = mysqli_query($conn, $insertGroup);
                            header("location:addUser.php?added=1");
                        }
                    }
                }
                else
                {
                    // Add a new user

                    // Hashing important data 
                    $hashPassword=password_hash($password,PASSWORD_DEFAULT);
                    // echo $hashPassword;
                    $insertSql="INSERT INTO `users` (`username`,`password`,`name`) VALUES ('$ITS','$hashPassword','$name')";
                    $insertResult=mysqli_query($conn,$insertSql);
                    
                    // By default add the user in All group and also add him in some other group if specified
                    if($group == 'All')
                    {
                        // Add user only in 'All' group
                        $insertGroup = "INSERT INTO `groups` (`username`,`All`) VALUES ('$ITS','1')";
                        $insertGroupResult = mysqli_query($conn, $insertGroup);
                    }
                    else
                    {
                        // Add user in some other group also along with group'All'
                        $insertGroup = "INSERT INTO `groups` (`username`,`All`,`$group`) VALUES ('$ITS','1','1')";
                        $insertGroupResult = mysqli_query($conn, $insertGroup);
                    }

                    // Redirecting towards addUser.php after successfull add
                    header("location:addUser.php?added=1");
                }
            }
            else
            {
                // Admin not logged in some non-admin user trying to access
                session_unset();
                session_destroy();
                header("location:../index.php");
            }
        }
        else
        {
            header("location:addUser.php");
        }
    }
    else
    {
        header("location: ../index.php?login=1");
    }
?>