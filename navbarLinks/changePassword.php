<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="changePassword.css">
    <link rel="stylesheet" href="../footer/footer.css">

    <style>
        #hidden{
            display: none;
        }
    </style>
  </head>
  <body class="d-flex flex-column vh-100">
    <?php
        session_start();
        if(isset($_SESSION['login']))
        {
            // Getting the ITS of the currently logged in user
            $ITS=$_SESSION['username'];
            require("../databaseConnect.php");
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            require("../navbar/navbar.php");
            echo '
                <div class="container">
                    <div class="text-center headingOfChangePassword">
                        <span id="heading2" class="text-center userList"><b>Change Password</b></span> 
                    </div>
                </div>

                <div class="container py-3 formContainerOfChangePassword">
                    <form action="changePasswordHandler.php" method="post">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="text" class="form-control inputs" id="password" aria-describedby="emailHelp" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary" id="changePasswordBtn">Change Password</button>
                    </form>
                </div>
            ';
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
            require "../footer/footer.php";
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
                    window.location.href = "../navbarLinks/logoutHnadler.php?multipleLogin=1"
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> -->
    <script src="changePassword.js"></script>
  </body>
</html>