<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Admin</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <style>
        #hidden{
            display: none;
        }
    </style>
    <!-- <link rel="stylesheet" href="../footer/footer.css"> -->
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
                            <span id="heading2" class="text-center userList"><b>Make Admin</b></span> 
                        </div>
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="makeAdminHandler.php">
                                <div class="mb-3">
                                    <label for="group" class="form-label"><b>Enter ITS</b></label>
                                    <input type="text" class="form-control" id="group" aria-describedby="emailHelp" name="its">
                                </div>
                                <center><button class="btn btn-primary">Make admin</button></center>
                            </form>
                        </div>
                    </div>';
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
            // Login session not started
            header("location:../index.php?login=1");
        }

        if(isset($_GET['userNotExists']))
        {
            $message = "User Does not exists in SBPT-2";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['added']))
        {
            $message = "Operation Successful";
            require "../modal.php";
            echo "
            <script src='../home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
        }

        if(isset($_GET['alreadyAdded']))
        {
            $message = "User is already admin";
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