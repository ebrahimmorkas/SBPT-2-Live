<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <?php
        session_start();
        require "../databaseConnect.php";        
        $username = $_SESSION['username'];
        $selectSql = "SELECT * FROM admins WHERE username='$username'";
        $selectResult = mysqli_query($conn, $selectSql);
        $numOfRows = mysqli_num_rows($selectResult);
        echo'
        <nav class="navbar navbar-expand-lg bg-body-tertiary" id="usernavbar" style="background-color: #c99c9c !important">
            <div class="container-fluid">
                <a class="navbar-brand" href="">'.$username.'</a>
                <button class="navbar-toggler" id="one" type="button" data-bs-toggle="collapse" data-bs-target="#nMobile" aria-controls="nMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="nMobile">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../home/home.php">Home</a>
                        </li>';
                        if($numOfRows > 0)
                        {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/addGroup.php">Add User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/uploadVideo.php">Upload Video</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/addGroup.php">Groups</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/servers.php">Servers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/makeAdmin.php">Make Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../navbarLinks/users.php">Users</a>
                            </li>
                            ';
                        }
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../navbarLinks/contactUs.php">Contact Us</a>
                        </li>
                    </ul>
                    <a class="btn btn-outline-light mx-2" type="submit" href="../navbarLinks/changePassword.php">Change password</a>
                    <a class="btn btn-outline-secondary" type="submit" href="../navbarLinks/logoutHnadler.php">Logout</a>
                </div>
            </div>
        </nav>
        ';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> -->
    </body>
</html>
