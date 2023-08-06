<?php
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $ITS=$_POST['username'];
        $password=$_POST['password'];
        $time=$_POST['time'];

        if($ITS=="")
        {
            // echo "email empty";
            header("location:home.php?usernameEmpty=1");
        }
        else
        {
            if($password=="")
            {
                // echo "password  Empty";
                header("location:home.php?passwordEmpty=1");
            }
            else
            {
                // If both the fields are filled with some value

                // Connecting the database
                require "../databaseConnect.php";

                $selectSql="SELECT * FROM users WHERE username='$ITS'";
                $selectResult=mysqli_query($conn,$selectSql);
                $numOfRows=mysqli_num_rows($selectResult);

                // Checking whether username exists or not
                if($numOfRows)
                {
                    // Username exists
                    // echo "Username exists";

                    $row=mysqli_fetch_assoc($selectResult);

                    // Checking whether the entered password is correct or not
                    if(password_verify($password,$row['password']))
                    {
                        // Password is right

                        // Checking for multiple logins
                        if($row['noOfLoginsAllowed']==$row['isLoggedIn'])
                        {
                            // User already logged in
                            header("location:login.php?alreadyLoggedIn=1");
                        }
                        else
                        {
                            // User is logging for first time in a day
                            // echo "Welcome";

                            session_start();
                            $_SESSION['login']=true;
                            $_SESSION['username']=$row['username'];

                            // Inserting the time of login into database
                            $updateSql="UPDATE `users` SET `timeOfLogin` = '$time' WHERE (`username` = '$ITS')";
                            $updateResult=mysqli_query($conn,$updateSql);

                            header("location:../home/home.php");
                        }
                    }
                    else
                    {
                        // Password is not right
                        // echo "Password wrong";
                        header("location:login.php?passwordWrong=1");
                    }
                }
                else
                {
                    // Username does not exist
                    // echo "Username does not exists";
                    header("location:login.php?usernameWrong=1");
                }
            }
        }
    }
    else
    {
        header("location:login.php");
    }
?>