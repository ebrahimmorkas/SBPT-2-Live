<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            require "../databaseConnect.php";
            // Checking whether the logged in user is admin
            $username = $_SESSION['username'];
            $selectSql = "SELECT * FROM admins WHERE username = '$username'";
            $selectResult = mysqli_query($conn, $selectSql);
            $numOfRows = mysqli_num_rows($selectResult);
            if($numOfRows > 0)
            {
                $groupName =$_POST['group'];
                if($groupName != "")
                {
                    // Not empty
                    $createRowSql = "ALTER TABLE `groups` ADD COLUMN `$groupName` VARCHAR(45) NULL DEFAULT '0'";
                    $createRowSqlResult = mysqli_query($conn, $createRowSql);

                    // Adding the group column in link table
                    $createRowSql1 = "ALTER TABLE `link` ADD COLUMN `$groupName` VARCHAR(45) NULL DEFAULT '0'";
                    $createRowSqlResult1 = mysqli_query($conn, $createRowSql1);

                    // Adding all the admins in that group
                    $selectAdmins= "SELECT * FROM `admins`";
                    $selectAdminsResult = mysqli_query($conn, $selectAdmins);
                    while($row = mysqli_fetch_assoc($selectAdminsResult))
                    {
                        $adminUsername = $row['username'];
                        $updateSql = "UPDATE `groups` SET `$groupName` = '1' WHERE (`username` = '$adminUsername')";
                        $updateResult = mysqli_query($conn, $updateSql);
                    }

                    header("location:addGroup.php?groupAdded=1");
                }
                else
                {
                    // empty
                    header("location:addGroup.php?empty=1");
                }
            }
            else
            {
                // Not admin
                // echo "Not";
                session_unset();
                session_destroy();
                header("location:../index.php");
            }
        }
        else
        {
            // Page accessed directly
            // echo "access";
            header("location:../addGroup.php");
        }
    }
    else
    {
        // session not started
        // echo "session";
        header("location:../index.php");
    }
?>