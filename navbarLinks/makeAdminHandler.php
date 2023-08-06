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

                // Getting the its entered in the field
                $fieldUsername = $_POST['its'];

                if($fieldUsername != "")
                {
                    // Field is not empty
                    // Check whether this its exist in users group if yes then only add in `admins` table 
                    $selectUser = "SELECT * FROM `users` WHERE `username`='$fieldUsername'";
                    $selectUserResult = mysqli_query($conn, $selectUser);
                    $numberOfRows = mysqli_num_rows($selectUserResult);
                    if($numberOfRows == 0)
                    {
                        // Not added in `users` group
                        
                        // Do nothing
                        header("location:makeAdmin.php?userNotExists=1");
                    }
                    else
                    {
                        // User is added in `users` group

                        // Check whether user is added in `admins` group if not added then add
                        $selectUserAdmin = "SELECT * FROM `admins` WHERE `username`='$fieldUsername'";
                        $selectUserAdminResult = mysqli_query($conn, $selectUserAdmin);
                        $adminNumberOfRows = mysqli_num_rows($selectUserAdminResult);
                        // echo $adminNumberOfRows;
                        if($adminNumberOfRows == 0)
                        {
                            // Not added in `admins` group

                            // Add him
                            $insertSql="INSERT INTO `admins` (`username`) VALUES ('$fieldUsername')";
                            $insertSqlResult = mysqli_query($conn, $insertSql);

                            // Add admin in all the aavailable groups
                            $selectColumn = "SHOW COLUMNS FROM `groups`";
                            $selectColumnsResult = mysqli_query($conn, $selectColumn);
                            while($row = mysqli_fetch_array($selectColumnsResult))
                            {
                                if($row['Field'] == 'id' || $row['Field'] == 'username')
                                {
                                    // Do nothing
                                }
                                else
                                {
                                    // Add the new admin in all the groups
                                    $column = $row['Field'];
                                    $updateSql = "UPDATE `groups` SET `$column` = '1' WHERE (`username` = '$fieldUsername')";
                                    $updateResult = mysqli_query($conn, $updateSql);
                                }
                            }

                            header("location:makeAdmin.php?added=1");
                        }
                        else
                        {
                            // User already admin
                            header("location:makeAdmin.php?alreadyAdded=1");
                        }
                    }
                }
                else
                {
                    // Field is empty
                    header("location:makeAdmin.php?empty=1");
                }
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
        header("location:../index.php");
    }
?>