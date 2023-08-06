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
                if(isset($_GET['id']))
                {
                    // ID is set 

                    // Getting the id
                    $id = $_GET['id'];

                    // Creating the array that will hold all the group names
                    $groupNames = array();

                    $selectGroupNames = "SHOW COLUMNS FROM `groups`";
                    $selectGroupNamesResult = mysqli_query($conn, $selectGroupNames);
                    while($namesOfGroup = mysqli_fetch_array($selectGroupNamesResult))
                    {
                        // Pushing all the group names in an array
                        if($namesOfGroup['Field'] == 'id' || $namesOfGroup['Field'] == 'username')
                        {
                            // Do nothing
                        }
                        else
                        {
                            // Add the group name in array
                            array_push($groupNames, $namesOfGroup['Field']);
                        }
                    }

                    // Values from users.php of checkbox
                    $valuesOfGroups = array();

                    // Writing script for fetching the username of user with the help oof id in get request
                    $selectUserFromGroup = "SELECT * FROM `users` WHERE `id`='$id'";
                    $selectUserFromGroupResult = mysqli_query($conn, $selectUserFromGroup);
                    $rowOfSelectUserFromGroup = mysqli_fetch_assoc($selectUserFromGroupResult);

                    // Fetching the username
                    $usernameForGroup = $rowOfSelectUserFromGroup['username'];

                    // Getting the values from the checkbox with the help of for loop the number of elements present in $groupNames indicates the number of checkboxs available on users.php
                    for($i = 0 ; $i < count($groupNames) ; $i++)
                    {
                        $name = "checkbox".$i;
                        // Creating the variable that will hold the current group name in the iteration
                        $groupName = $groupNames[$i];

                        if(isset($_POST["$name"]))
                        {
                            // Check the value and push 1 in array because these checkboxs are selected
                            array_push($valuesOfGroups, '1');

                            echo $groupName."<br>"    ;
                            echo $id;

                            $updateSql = "UPDATE `groups` SET `$groupName` = '1' WHERE (`username` = '$usernameForGroup')";
                            $updateSqlResult = mysqli_query($conn, $updateSql);
                        }
                        else
                        {
                            // The checkbox has not been checked, just push zero
                            array_push($valuesOfGroups, '0');
                            $updateSql = "UPDATE `groups` SET `$groupName` = '0' WHERE (`username` = '$usernameForGroup')";
                            $updateSqlResult = mysqli_query($conn, $updateSql);
                        }
                    }
                    header("location:users.php?updated=1");
                }
                else 
                {
                    // ID is not set someone tried to break in
                    header("location:users.php");
                }
            }
            else
            {
                // Accessed directly
                header("location: users.php");
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

// $value = $_POST["'$j'"];
                            // if($value == 1)
                            // {
                            //     // Do nothing just push the value in the array
                            //     array_push($valuesOfGroups, '1');
                            // }
                            // else
                            // {
                            //     // If the value set was '0' but now it has been checked in updation so again push 1 intead of zero
                            //     array_push($valuesOfGroups, '1');
                            // }