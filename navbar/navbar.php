<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  <style>
    @media screen and (max-width: 991px) {
        .diff-links {
            text-align: center;
        }
        }
        @media screen and (max-width: 991px) {
        .flex-form-buttons {
            margin-top:5px;
        }
        }
        
  </style>
</head>
<body>
<?php
    require "../databaseConnect.php";
    $username = $_SESSION['username'];
    echo '
    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="usernavbar" style="background-color: #c99c9c !important">
    <div class="container-fluid">
      <a class="navbar-brand " href=""><b>'.$username.'</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 diff-links">
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="../home/home.php">Home</a>
        </li>';
          $selectSql = "SELECT * FROM admins WHERE username='$username'";
      $selectResult = mysqli_query($conn, $selectSql);
      $numOfRows = mysqli_num_rows($selectResult);
          if($numOfRows > 0)
          {
              // User is admin
              echo '
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/addUser.php">Add User</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/uploadVideo.php">Upload Video</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/addGroup.php">Groups</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/servers.php">Servers</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/makeAdmin.php">Make Admin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/users.php">Users</a>
              </li>
              ';
          }
                echo '
                <li class="nav-item">
                <a class="nav-link" href="../navbarLinks/contactUs.php">Contact Us</a>
                </li>
              </ul>
              <form class="d-flex" role="search" id="myElement">
              <div class="diff-links flex-form-buttons">
              <a class="btn btn-outline-light mx-2" type="submit" href="../navbarLinks/changePassword.php">Change password</a>
              <a class="btn btn-outline-secondary" type="submit" href="../navbarLinks/logoutHnadler.php">Logout</a>
              </div>
              </form>
            </div>
          </div>
        </nav>
          ';
?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script>
    // Define the media query
    const mediaQuery = window.matchMedia('(min-width: 991px)');

    // Function to handle the media query change
    const handleWidthChange = (mq) => {
      if (mq.matches) {
        // Remove the class from the element
        document.getElementById('myElement').classList.remove('d-flex');
      }
    };

    // Call the function initially to check the current width
    handleWidthChange(mediaQuery);

    // Attach the listener to the media query change event
    mediaQuery.addEventListener('change', (e) => handleWidthChange(e.target));

  </script>
</body>
</html>
