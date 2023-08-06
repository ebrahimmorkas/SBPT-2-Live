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
                $its = $_POST['userITS'];
                $length = strlen($its);
                if($length == 8)
                {
                    // ITS is correctly entered

                    // Change the $_Session['user'] with the its 
                    $_SESSION['user'] = $its;
                    header("location:users.php");
                }
                else
                {
                    // ITS is not correclty entered

                    $_SESSION['user'] = 0;
                    header("location:users.php?wrongFormat=1");
                }
            }
            else if(isset($_GET['showall']))
            {
                // Check whether the show all button is clicked

                $_SESSION['user'] = 0;
                header("location:users.php");
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
        header("location:../index.php?login=1");
    }
?>