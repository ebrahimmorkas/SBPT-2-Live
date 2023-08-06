<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">

    <style>
        .search-field{
            opacity: 65%;
            width: 59vw;
            display: flex;
            flex-direction: row;
            /* background-color: black; */
        }

        .search-form{
            display: flex;
            flex-direction: row;
        }

        #search-input{
            width: 47vw;
            /* color: white; */
        }

        .tableContainer{
            /* width: 820px; */
            /* background-color: #ebd9d9 !important; */
            border-radius: 21px;
            opacity: 75%;
            height: 332px;
            max-width: fit-content;
            overflow: scroll;

            
        }

        /* Hide the scrollbar */
::-webkit-scrollbar {
  width: 0.5em;
  background-color: transparent;
}

/* Track */
::-webkit-scrollbar-track {
  background-color: transparent;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background-color: transparent;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background-color: transparent;
}

        @media screen and (max-width: 990px) {
        .search-form{
            flex-direction: column;
        }
        .search-field{
            flex-direction: column;
        }
        }

        #hidden{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="../footer/footer.css">
</head>
<body class="d-flex flex-column vh-100">
    <?php
        session_start();
        if(isset($_SESSION['login']))
        {
            require "../databaseConnect.php";
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            // Check for admin
            $username = $_SESSION['username'];
            $selectSql = "SELECT * FROM `admins` WHERE `username`='$username'";
            $selectResult = mysqli_query($conn, $selectSql);
            $numOfRows = mysqli_num_rows($selectResult);

            if($numOfRows > 0)
            {
                // Admin logged in

                require "../navbar/navbar.php";
                $selectGroups = "SHOW COLUMNS FROM `groups`";
                $selectGroupsResult = mysqli_query($conn, $selectGroups);
                echo '
                <div class="container">
                    <div class="text-center addUserHeading">
                        <span id="heading2" class="text-center userList"><b>List of Users</b></span> 
                    </div>
                    <center><h5>If you are making any changes then click on <b>save</b> button if the page refreshes the <b>changes</b> wont be saved</h5></center>
                    <center>
                    
                        <br>
                        <center>
                        <div class="search-field">
                            <form method="POST" action="userSearchHandler.php" class="search-form">
                                <div class="input-group flex-nowrap">
                                    <input id="search-input" type="number" class="form-control" placeholder="Please enter exact 8 digit ITS number" aria-label="Username" aria-describedby="addon-wrapping" name="userITS">
                                </div>
                                <button class="btn btn-secondary" ttype="submit">Search</button>
                            </form>
                            <a class="btn btn-primary" href="userSearchHandler.php?showall=1">Show All</a>
                        </div>
                        </center>
                        <br>
                        <div class="tableContainer">
                            <table class="table text-center">
                            <thead>
                                <tr scope="row">
                                <th scope="col">Sr No.</th>
                                <th scope="col">ITS</th>';
                                $groupNames = array();
                                while($column = mysqli_fetch_array($selectGroupsResult))
                                {
                                    if($column['Field'] == 'id' || $column['Field'] == 'username')
                                    {
                                        // Do nothing
                                    }
                                    else
                                    {
                                        echo '
                                        <th scope="col">'.$column['Field'].'</th>
                                        ';
                                        array_push($groupNames, $column['Field']);
                                    }
                                }
                                echo '
                                <th scope="col">Save Changes</th>
                                <th scope="col">Change Password</th>
                                <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                ';
                $i = 1;
                $selectUsers = "SELECT * FROM `users`";
                $selectUsersResult = mysqli_query($conn, $selectUsers);
                if($_SESSION['user'] == 0)
                {
                while($row = mysqli_fetch_assoc($selectUsersResult))
                {
                    echo '
                        <tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$row['username'].'</td>
                    ';
                    $currentUser = $row['username'];
                    $selectGroupOfUser = "SELECT * FROM `groups` WHERE `username`='$currentUser'";
                    $selectGroupOfUserResult = mysqli_query($conn, $selectGroupOfUser);
                    $result = mysqli_fetch_assoc($selectGroupOfUserResult);

                    $id = $row['id'];

                    echo '<form action="removeUserFromGroupHandler.php?id='.$id.'" method="POST">';
                    for($j = 0 ; $j < count($groupNames) ; $j++)
                    {
                        $name = "checkbox".$j;
                        if('1' == $result[$groupNames[$j]])
                        {
                            // If the row is of admin then his checkbox should be disbale so no one can edit that thing. All the buttons of the admin will be disabled so no admin can also edit another admin
                            if($row['username'] == $username)
                            {
                                echo '
                                <td>
                                    <input class="form-check-input" type="checkbox" value="1" name="'.$name.'" id="defaultCheck2" checked style="border: 1px solid black" disabled>
                                </td>
                                ';
                            }
                            else
                            {
                                echo '
                                <td>
                                    <input class="form-check-input" type="checkbox" value="1" name="'.$name.'" id="defaultCheck2" checked style="border: 1px solid black">
                                </td>
                                ';
                            }
                        }
                        else
                        {
                            echo '
                            <td>
                                <input class="form-check-input" type="checkbox" value="0" name="'.$name.'" id="defaultCheck2" style="border: 1px solid black">
                            </td>
                            ';
                        }                        
                    }
                    if($row['username'] == $username)
                    {
                        echo '
                            <td><button disabled class="btn btn-secondary" type="submit">Save</button></td>
                            </form>
                            <td><button disabled class="btn btn-primary" href="changePasswordFromAdmin.php?id='.$id.'">Change</button></td>
                            <td><button disabled class="btn btn-danger" href="deleteUserHandler.php?id='.$id.'">Delete</button></td>
                            ';
                    }
                    else
                    {
                        echo '
                            <td><button class="btn btn-secondary" type="submit">Save</button></td>
                            </form>
                            <td><a class="btn btn-primary" href="changePasswordFromAdmin.php?id='.$id.'">Change</a></td>
                            <td><a class="btn btn-danger" href="deleteUserHandler.php?id='.$id.'">Delete</a></td>
                            ';
                    }
                    $i++;
                }
            }
            else
            {
                $its = $_SESSION['user'];
                $selectIts = "SELECT * FROM `users` WHERE `username`='$its'";
                $selectItsResult = mysqli_query($conn, $selectIts);
                $numberOfRows = mysqli_num_rows($selectItsResult);
                if($numberOfRows > 0)
                {
                    $row = mysqli_fetch_assoc($selectItsResult);
                    echo '
                    <tr>
                    <th scope="row">1</th>
                    <td>'.$row['username'].'</td>
                    ';
                        $currentUser = $row['username'];
                        $selectGroupOfUser = "SELECT * FROM `groups` WHERE `username`='$currentUser'";
                        $selectGroupOfUserResult = mysqli_query($conn, $selectGroupOfUser);
                        $result = mysqli_fetch_assoc($selectGroupOfUserResult);

                        $id = $row['id'];

                        echo '<form action="removeUserFromGroupHandler.php?id='.$id.'" method="POST">';
                        for($j = 0 ; $j < count($groupNames) ; $j++)
                        {
                            $name = "checkbox".$j;
                            if('1' == $result[$groupNames[$j]])
                            {
                                // If the row is of admin then his checkbox should be disbale so no one can edit that thing. All the buttons of the admin will be disabled so no admin can also edit another admin
                                if($row['username'] == $username)
                                {
                                    echo '
                                    <td>
                                        <input class="form-check-input" type="checkbox" value="1" name="'.$name.'" id="defaultCheck2" checked style="border: 1px solid black" disabled>
                                    </td>
                                    ';
                                }
                                else
                                {
                                    echo '
                                    <td>
                                        <input class="form-check-input" type="checkbox" value="1" name="'.$name.'" id="defaultCheck2" checked style="border: 1px solid black">
                                    </td>
                                    ';
                                }
                            }
                            else
                            {
                                echo '
                                <td>
                                    <input class="form-check-input" type="checkbox" value="0" name="'.$name.'" id="defaultCheck2" style="border: 1px solid black">
                                </td>
                                ';
                            }                        
                        }
                        if($row['username'] == $username)
                        {
                            echo '
                                <td><button disabled class="btn btn-secondary" type="submit">Save</button></td>
                                </form>
                                <td><button disabled class="btn btn-primary" href="changePasswordFromAdmin.php?id='.$id.'">Change</button></td>
                                <td><button disabled class="btn btn-danger" href="deleteUserHandler.php?id='.$id.'">Delete</button></td>
                                ';
                        }
                        else
                        {
                            echo '
                                <td><button class="btn btn-secondary" type="submit">Save</button></td>
                                </form>
                                <td><a class="btn btn-primary" href="changePasswordFromAdmin.php?id='.$id.'">Change</a></td>
                                <td><a class="btn btn-danger" href="deleteUserHandler.php?id='.$id.'">Delete</a></td>
                                ';
                        }
                        $_SESSION['user'] = 0;
                }
                else
                {
                    echo "<h3 class='mb-3'>The user does not exist</h3>";
                    $_SESSION['user']=0;
                }
            }
                echo '</form>
                    </tbody>
                    </table>
                    </div>
                    </center>
                    </div>
                    <div class="mb-5"></div>
                    ';
                require "../footer/footer.php";
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

        if(isset($_GET['deleted']))
        {
            $message = "User Deleted Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['updated']))
        {
            $message = "User Updated Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['changed']))
        {
            $message = "Password Changed Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['wrongFormat']))
        {
            $message = "ITS number should contain exactly 8 numbers";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }
        require "../disableDevTools.php";
    ?>
    <script>
        function check_session()
        {
            let session_id = "<?php echo $_SESSION['token']; ?>"
            fetch('../detection.php').then(function(response){
                return response.json();
            }).then(function(responseData){
                console.log(responseData);
                if(responseData.output == 'logout'){
                    window.location.href = "../navbarLinks/logoutHnadler.php?multipleLogin=1"
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);

        // Code to disable 'ctrl' + '-'
        document.addEventListener("keydown", function(event) {
        // Check if Ctrl and minus key are pressed
        if (event.ctrlKey && event.key === "-") {
            event.preventDefault(); // Prevent the default behavior
            // Add your own code here to handle the event or perform any desired action
        }
        });

        // Code to disable 'ctrl' + '+'
        document.addEventListener("keydown", function(event) {
        // Check if Ctrl and plus key are pressed
        if (event.ctrlKey && event.key === "+") {
            event.preventDefault(); // Prevent the default behavior
            // Add your own code here to handle the event or perform any desired action
        }
        });
    </script>
</body>
</html>