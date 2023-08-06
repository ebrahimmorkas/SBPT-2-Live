<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="icon" href="websiteLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="index.css">
    <style>
        #logo{
            width: 250px;
            height: 250px;
        }

        .toggle{
            cursor: pointer;
        }

        /* Disable resizing by Chrome resizer */
        html::-webkit-resizer {
        display: none;
        }


        html, body {
            /* Prevent scaling and zooming */
            touch-action: manipulation;
            -ms-touch-action: manipulation;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -webkit-tap-highlight-color: transparent;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            }

            /* Optionally, you can disable pinch zooming on specific elements */
            /* For example, to disable zooming on images */
            img {
            pointer-events: none;
            user-select: none;
            }
    </style>

    <script>
        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) 
        {
        window.location.href="index.php";
        }
  </script>
</head>

<body>
    <?php
    session_start();
    if(isset($_SESSION['login']))
    {
        // Redirect to home page
        header("location:home/home.php");
    }
    else
    {
    // Show login form
    echo '
        <!-- Start of login form -->
        <div class="container" id="loginBox">
            <div id="loginFormContainer">
            <!-- <img src="sbutLogo.jpg" alt="" class="text-center"> -->
            <img src="websiteLogo.png" alt="" class="text-center" id="logo">
            <form method="POST" action="loginHandle.php">
                <div class="mb-3">
                    <label for="its" class="form-label">ITS No.</label>
                    <input type="number" class="form-control" id="its" aria-describedby="emailHelp" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input toggle" type="checkbox" value="" id="togglePassword">
                    <label class="form-check-label toggle" for="togglePassword">
                    Show Password
                    </label>
                </div>
                <center><button type="submit" class="btn btn-secondary" id="loginBtn">Login</button><center>
            </form>
            </div>
        </div>
        <!-- End of login form -->
        ';
    if(isset($_GET['usernameWrong'])) {
        $message = "Username Wrong";
        require "modal.php";
        echo "
            <script src='home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
    }
    if(isset($_GET['passwordWrong'])) {
        $message = "Password Wrong";
        require "modal.php";
        echo "
            <script src='home/jquery-3.7.0.min.js'></script>
                <script>
                    console.log('Hello');
                    $('#button').click();
                </script>
            ";
    }
    if(isset($_GET['login'])) {
        $message = "Please login to continue";
        require "modal.php";
        echo "
            <script src='home/jquery-3.7.0.min.js'></script>
                <script>
                    $('#button').click();
                </script>
            ";
    }
    if(isset($_GET['multipleLogin'])) {
        $message = "Multiple login detected";
        require "modal.php";
        echo "
            <script src='home/jquery-3.7.0.min.js'></script>
                <script>
                    $('#button').click();
                </script>
            ";
    }
    if(isset($_GET['multipleLogin'])) {
        $message = "Multiple Login Detected";
        require "modal.php";
        echo "
            <script src='home/jquery-3.7.0.min.js'></script>
                <script>
                    $('#button').click();
                </script>
            ";
    }
}

// Disabling dev tools
require "disableIndexDevTools.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
        <!-- <script src="index.js"></script> -->
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');

            togglePassword.addEventListener('change', function () {
            const isChecked = togglePassword.checked;
            passwordField.type = isChecked ? 'text' : 'password';
            });
        </script>
</body>

</html>