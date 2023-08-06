<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Server</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="admin.css">
    <style>
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
            echo '
            <div id="hidden">
                require "../detection.php";
            </div>
            ';
            // Check for admin
            $username = $_SESSION['username'];
            $selectSql = "SELECT * FROM `admins` WHERE `username`='$username'";
            $selectResult = mysqli_query($conn, $selectSql);
            $numOfRows = mysqli_num_rows($selectResult);
            if($numOfRows > 0)
            {
                // Admin logged in

                if($_SERVER['REQUEST_METHOD'] == 'GET')
                {
                    // Not accessed directly
                    require "../navbar/navbar.php";

                    $id = $_GET['id'];
                    $selectSql = "SELECT * FROM `servers` WHERE `id`='$id'";
                    $selectResult = mysqli_query($conn, $selectSql);
                    $row = mysqli_fetch_assoc($selectResult);
                    $serverName = $row['name'];
                    echo '
                    <div class="container">
                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>Edit Server</b></span> 
                        </div>

                        <!-- Start of form -->
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="editServerHandler.php">
                                <div class="mb-3">
                                    <b><label for="serverName" class="form-label">Server Name</label></b>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="serverName" value="'.$serverName.'" required>

                                    <input type="text" class="form-control" id="hidden" aria-describedby="emailHelp" name="id" value="'.$id.'">
                                </div>';
                                if($row['video'] == 1)
                                {
                                    // Audio and video is set for the server
                                    echo '
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
                                    </div>';
                                }
                                else
                                {
                                    // Server is set for only audio
                                    echo '
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="choice" id="flexRadioDefault1" value="video">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Audio and Video
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="choice" id="flexRadioDefault2" value="audio" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Only Audio
                                        </label>
                                    </div>';
                                }
                                echo '
                                <button type="submit" class="btn btn-primary" id="addUserBtn" href="addUserHandler.php">Save</button>
                            </form>
                        </div>
                    </div>';

                    require "../footer/footer.php";
                }
                else
                {
                    // Accessed directly
                    header("location:servers.php");
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
                    window.location.href = "../navbarLinks/logoutHnadler.php?multipleLogin=1";
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);
    </script>
</body>
</html>