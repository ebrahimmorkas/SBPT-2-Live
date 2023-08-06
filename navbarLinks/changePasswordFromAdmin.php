<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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

                if($_SERVER['REQUEST_METHOD'] == 'GET')
                {
                    // Not accessed directly
                    require "../navbar/navbar.php";
                    $id = $_GET['id'];
                echo '
                    <div class="container">
                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>Change Password</b></span> 
                        </div>
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="changePasswordFromAdminHandler.php">
                                <div class="mb-3">
                                    <center><label for="group" class="form-label"><b>New Password</b></label></center>
                                    <input type="text" class="form-control" id="group" aria-describedby="emailHelp" name="password">
                                </div>
                                <div class="mb-3" id="hidden">
                                    <label for="group" class="form-label"><b>New Password</b></label>
                                    <input type="text" class="form-control" aria-describedby="emailHelp" name="id" value="'.$id.'">
                                </div>
                                <center><button class="btn btn-primary">Change Password</button></center>
                            </form>
                        </div>
                    </div>
                    ';
                    require "../footer/footer.php";
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
        require "../disableDevTools.php";

        if(isset($_GET['changed'])) {
            $message = "Password Changed Successfully";
            require "../modal.php";
            echo "
                <script src='../home/jquery-3.7.0.min.js'></script>
                    <script>
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