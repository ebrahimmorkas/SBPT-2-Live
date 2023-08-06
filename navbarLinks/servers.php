<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Servers</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
</head>
<body  class="d-flex flex-column vh-100">
    <?php
        session_start();
        if(isset($_SESSION['login']))
        {
            require("../databaseConnect.php");
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            // Fetching the ITS of currently logged in user
            $username=$_SESSION['username'];
            $selectSql="SELECT * FROM admins WHERE username='$username'";
            $selectResult=mysqli_query($conn,$selectSql);
            $numOfRows = mysqli_num_rows($selectResult);
            if($numOfRows > 0) 
            {
                require("../navbar/navbar.php");
                echo '
                    <div class="container">
                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>Add Server</b></span> 
                        </div>

                        <!-- Start of form -->
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="addServerHandler.php">
                                <div class="mb-3">
                                    <b><label for="serverName" class="form-label">Server Name</label></b>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="serverName" required>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="choice" id="flexRadioDefault1" value="video" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Audio and Video
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="choice" id="flexRadioDefault2" value="audio">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Only Audio
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary" id="addUserBtn" href="addUserHandler.php">Create</button>
                            </form>
                        </div>

                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>List of Servers</b></span> 
                        </div>
                        <center><h5 class="mb-4">Please dont delete any server while streaming is on or else video on that server will be stopped</h5></center>
                        <center>
                            <div class="tableContainer mb-5">
                                <table class="table text-center">
                                <thead>
                                    <tr scope="row">
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Server Name</th>
                                    <th scope="col">Audio And Video</th>
                                    <th scope="col">Only Audio</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $i=1;
                                $selectServers = "SELECT * FROM `servers`";
                                $selectServersResult = mysqli_query($conn, $selectServers);
                                while($row = mysqli_fetch_assoc($selectServersResult))
                                {   
                                    echo '
                                        <tr>
                                        <th scope="row">'.$i.'</th>
                                        <td>'.$row['name'].'</td>
                                        ';
                                        if($row['video'] == '1')
                                        {
                                            echo '
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" checked disabled>
                                                </td>
                                            ';
                                        }
                                        else
                                        {
                                            echo '
                                                <td>
                                                    <b>-</b>
                                                </td>
                                            ';
                                        }
                                        if($row['audio'] == '1')
                                        {
                                            echo '
                                                <td>
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" checked disabled>
                                                </td>
                                            ';
                                        }
                                        else
                                        {
                                            echo '
                                                <td>
                                                    <b>-</b>
                                                </td>
                                            ';
                                        }
                                        $id = $row['id'];
                                        echo '
                                            <td><a class="btn btn-secondary" href="editServer.php?id='.$id.'">Edit</a></td>
                                            <td><a class="btn btn-danger" href="deleteServer.php?id='.$id.'">Delete</a></td>
                                            </tr>
                                        ';
                                        
                                    $i++;
                                }
                                echo '
                                </tbody>
                                </table>
                            </div>
                        </center>
                    </div>';
                require "../footer/footer.php";
            }
            else
            {
                // Not admin
                session_unset();
                session_destroy();
                header("location:../index.php");
            }
        }
        else
        {
            // Login session not set 992
            header("location:../index.php?login=1");
        }

        if(isset($_GET['added']))
        {
            $message = "Server Updated Successfully";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['serverNameAlreadyExists']))
        {
            $message = "Server Name Already Exists";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['empty']))
        {
            $message = "Please fill out the server name";
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
            $message = "Server Updated Successfully";
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
            $message = "Server Deleted Successfully";
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
    </script>
</body>
</html>