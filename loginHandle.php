<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "")
    {
        // username empty
        header("location:index.php?usernameEmpty=1");
    }
    elseif($password == "")
    {
        // password empty
        header("location:index.php?passwordEmpty=1");
    }
    else
    {
        require "databaseConnect.php";
        $selectSql="SELECT * FROM users WHERE username='$username'";
        $selectResult=mysqli_query($conn,$selectSql);
        $numOfRows=mysqli_num_rows($selectResult);

        // Checking whether username exists or not
        if($numOfRows > 0)
        {
            $row=mysqli_fetch_assoc($selectResult);

                    // Checking whether the entered password is correct or not
                    if(password_verify($password,$row['password']))
                    {
                        // Password is right
                        session_start();
                        $_SESSION['login']=true;
                        $_SESSION['username']=$row['username'];
                        // This session will be used in home.php on admin side
                        $_SESSION['server'] = 0;
                        // This session will be used when we have to serach for the ITS ID in users page
                        $_SESSION['user'] = 0;
                        $token = session_create_id();
                        $updateSql = "UPDATE `users` SET `token` = '$token' WHERE (`username` = '$username')";
                        $upateResult = mysqli_query($conn, $updateSql);
                        $_SESSION['token'] = $token;
                        header("location:home/home.php");
                    }
                    else
                    {
                        // Password is wrong
                        header("location:index.php?passwordWrong=1");
                    }
        }
        else
        {
            // Username does not exists
            header("location:index.php?usernameWrong=1");
        }
    }
}
?>