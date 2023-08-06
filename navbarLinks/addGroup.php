<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Group</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="admin.css">
    <style>
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


        #hidden{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="../footer/footer.css">
</head>
<body class="d-flex flex-column vh-100">
    <?php
        // require "../navbar/navbar.php";
        session_start();
        if(isset($_SESSION['login']))
        {
            require "../databaseConnect.php";
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            // Checking whether the logged in user is admin
            $username = $_SESSION['username'];
            $selectSql = "SELECT * FROM admins WHERE username = '$username'";
            $selectResult = mysqli_query($conn, $selectSql);
            $numOfRows = mysqli_num_rows($selectResult);
            if($numOfRows > 0)
            {
                require "../navbar/navbar.php";
                echo '
                    <div class="container">
                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>Add Group</b></span> 
                        </div>
                        <div class="mb-3">
                            <center><b><h4>Please dont include space while writing group name</h4></b></center>
                        </div>
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="addGroupHandler.php">
                                <div class="mb-3">
                                    <label for="group" class="form-label"><b>Group Name</b></label>
                                    <input type="text" class="form-control" id="group" aria-describedby="emailHelp" name="group">
                                </div>
                                <center><button class="btn btn-primary">Add Group</button></center>
                            </form>
                        </div>
                        <div class="text-center addUserHeading">
                        <span id="heading2" class="text-center userList"><b>List of Groups</b></span> 
                    </div>';

                    // start of table

                    // Array that wll hold all the group names present inside the table
                    $groupNames = array();
                    $selectGroups = "SHOW COLUMNS FROM `groups`";
                    $selectGroupsResult = mysqli_query($conn, $selectGroups);
                    while($row = mysqli_fetch_array($selectGroupsResult))
                    {
                        if($row['Field'] == 'id' || $row['Field'] == 'username')
                        {
                            // Do nothing
                        }
                        else
                        {
                            array_push($groupNames, $row['Field']);
                        }
                    }
                    echo '
                    <center>
                        <div class="tableContainer">
                            <table class="table text-center">
                            <thead>
                                <tr scope="row">
                                <th scope="col">Sr No.</th>
                                <th scope="col">Group Name</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>';
                            $i=1;
                            for($j=0; $j < count($groupNames); $j++)
                            {
                                echo '
                                    <tr>
                                    <th scope="row">'.$i.'</th>
                                    ';
                                $index = $i - 1;
                                echo '
                                    <td>'.$groupNames[$index].'</td>';
                                    // Disabling the edit and delete button for group All
                                    if($groupNames[$index] == 'All')
                                    {
                                        echo '
                                        <td><button class="btn btn-primary" href="editGroup.php?id='.$groupNames[$index].'" disabled>Edit</button></td>
                                        <td><button class="btn btn-secondary" href="deleteGroupHandler.php?id='.$groupNames[$index].'" disabled>Delete</button></td>';
                                    }
                                    else
                                    {
                                    echo '
                                        <td><a class="btn btn-primary" href="editGroup.php?id='.$groupNames[$index].'">Edit</a></td>
                                        <td><a class="btn btn-secondary" href="deleteGroupHandler.php?id='.$groupNames[$index].'">Delete</a></td>';
                                    }
                                $i++;
                                    echo '   
                                        </tr>
                                    ';
                            }
                            echo '
                            </tbody>
                            </table>
                        </div>
                    </center>
               
                    
                </div> <!-- Closing of container -->
                <div class="mb-5"></div>
                ';

                require "../footer/footer.php";
                // script that will disable the devtools
                require "../disableDevTools.php";
            }
            else
            {
                // Logged in user is not admin
                session_unset();
                session_destroy();
                header("location:../index.php");
            }
        }
        else
        {
            // Login session not set
            header("location:../index.php?login=1");
        }
        if(isset($_GET['empty'])) {
            $message = "Please enter Group Name";
            require "../modal.php";
            echo "
                <script src='../home/jquery-3.7.0.min.js'></script>
                    <script>
                        $('#button').click();
                    </script>
                ";
        }

        if(isset($_GET['groupAdded'])) {
            $message = "Group Added Successfully";
            require "../modal.php";
            echo "
                <script src='../home/jquery-3.7.0.min.js'></script>
                    <script>
                        $('#button').click();
                    </script>
                ";
        }

        if(isset($_GET['updated']))
        {
            $message = "Group Updated Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['deleted']))
        {
            $message = "Group Deleted Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }
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
    </script>
</body>
</html>