<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Users</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
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
            require("../navbar/navbar.php");
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
                
                echo '
                    <div class="container">
                        <div class="text-center addUserHeading">
                            <span id="heading2" class="text-center userList"><b>Add User</b></span> 
                        </div>

                        <!-- Start of form -->
                        <div class="container mb-5" id="formContainer">
                            <form class="my-3" method="POST" action="addUserHandler.php">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="its" class="form-label">ITS*</label>
                                    <input type="number" class="form-control" id="its" name="its" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password*</label>
                                    <input type="password" class="form-control" id="phoneNo" aria-describedby="emailHelp" name="password" required>
                                </div>
                                <div class="mb-3">
                                <label for="group" class="form-label">Please select the group</label>
                                    <select class="form-select" name="group" aria-label="Default select example">
                                        <option selected value="All">All</option>
                                        ';
                                        $sql = "SHOW COLUMNS FROM `groups`";
                                        $result = mysqli_query($conn,$sql);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            // Logic:- Dont add first three fields of 'groups' table in dropdown i.e. 'id', 'username', 'All'
                                            if($row['Field'] == 'id' || $row['Field'] == 'username' || $row['Field'] == 'All')
                                            {}
                                            else
                                            {
                                            // echo $row['Field']."<br>";
                                            
                                            // Add all the columns in dropdown leaving forst three columns
                                            $value=$row['Field'];
                                            echo '<option value="'.$value.'">'.$row['Field'].'</option>';
                                            }
                                        }
                                    echo '
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" id="addUserBtn" href="addUserHandler.php">Add User</button>
                            </form>
                        </div>
                        <!-- End of form -->

                        <!-- Start of excel form -->
                        <div class="container mb-5" id="formContainer"> 
                            <form class="my-3" action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <center><label for="formFile" class="form-label"><b>Upload Excel file for many users</b></label></center>
                                    <label for="excel" class="form-label">upload excel(.xlxs) file</label>
                                    <input class="form-control" type="file" id="formFile" name="excel" required value="">
                                </div>
                                <div class="mb-3">
                                <label for="group" class="form-label">Please select the group</label>
                                    <select class="form-select" name="excelGroup" aria-label="Default select example">
                                        <option selected value="All">All</option>
                                        ';
                                        $sql1 = "SHOW COLUMNS FROM `groups`";
                                        $result1 = mysqli_query($conn,$sql1);
                                        while($row1 = mysqli_fetch_array($result1))
                                        {
                                            if($row1['Field'] == 'id' || $row1['Field'] == 'username' || $row1['Field'] == 'All')
                                            {}
                                            else
                                            {
                                            // echo $row['Field']."<br>";
                                            $value1 = $row1['Field'];
                                            echo '<option value="'.$value1.'">'.$row1['Field'].'</option>';
                                            }
                                        }
                                    echo '
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2" id="addUserBtn" name="import">Add Users</button>
                            </form>
                        </div>
                        <!-- End of excel form -->

                        <!-- Start of form that will add existing user in other groups leaving "All" -->
                        <div class="container mb-5" id="formContainer"> 
                            <form class="my-3" action="addUserInGroupHandler.php" method="post" enctype="multipart/form-data">
                            <center><label for="formFile" class="form-label"><b>Add User in Group</b></label></center>
                                <div class="mb-3">
                                    <label for="its" class="form-label">ITS*</label>
                                    <input type="number" class="form-control" id="its" name="its" required>
                                </div>
                                <div class="mb-3">
                                    <label for="group" class="form-label">Please select the group</label>
                                        <select class="form-select" name="group" aria-label="Default select example">
                                            <option selected value="All">All</option>
                                            ';
                                            $sql2 = "SHOW COLUMNS FROM `groups`";
                                            $result2 = mysqli_query($conn,$sql2);
                                            while($row2 = mysqli_fetch_array($result2))
                                            {
                                                if($row2['Field'] == 'id' || $row2['Field'] == 'username' || $row2['Field'] == 'All')
                                                {}
                                                else
                                                {
                                                // echo $row['Field']."<br>";
                                                $value2 = $row2['Field'];
                                                echo '<option value="'.$value2.'">'.$row2['Field'].'</option>';
                                                }
                                            }
                                        echo '
                                        </select>
                                </div>
                                <button type="submit" class="btn btn-primary" id="addUserBtn" href="addUserHandler.php">Add</button>
                            </form>
                        </div>
                        <!-- End of group form -->

                        <!-- Add in Different group through excel -->
                        <div class="container mb-5" id="formContainer"> 
                            <form class="my-3" action="differentGroupThroughExcelHandler.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <center><label for="formFile" class="form-label"><b>Add users in group through excel</b></label></center>
                                    <label for="excel1" class="form-label">upload excel(.xlxs) file</label>
                                    <input class="form-control" type="file" id="formFile" name="excel1" required value="">
                                </div>
                                <div class="mb-3">
                                <label for="group" class="form-label">Please select the group</label>
                                    <select class="form-select" name="group" aria-label="Default select example">
                                        <option selected value="All">All</option>
                                        ';
                                        $sql1 = "SHOW COLUMNS FROM `groups`";
                                        $result1 = mysqli_query($conn,$sql1);
                                        while($row1 = mysqli_fetch_array($result1))
                                        {
                                            if($row1['Field'] == 'id' || $row1['Field'] == 'username' || $row1['Field'] == 'All')
                                            {}
                                            else
                                            {
                                            // echo $row['Field']."<br>";
                                            $value1 = $row1['Field'];
                                            echo '<option value="'.$value1.'">'.$row1['Field'].'</option>';
                                            }
                                        }
                                    echo '
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2" id="addUserBtn" name="updateGroup">Add</button>
                            </form>
                        </div>
                        <!-- End of adding in group through excel -->
                    </div>
                ';

                // Processing of excel file
                if(isset($_POST["import"])){
                    $fileName = $_FILES["excel"]["name"];
                    $fileExtension = explode('.', $fileName);
                    $fileExtension = strtolower(end($fileExtension));
                    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
        
                    $targetDirectory = "uploads/" . $newFileName;
                    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);
        
                    // $targetDirectory = "/uploads/"
        
                    error_reporting(0);
                    ini_set('display_errors', 0);
        
                    require 'excelReader/excel_reader2.php';
                    require 'excelReader/SpreadsheetReader.php';
        
                    $reader = new SpreadsheetReader($targetDirectory);
                    foreach($reader as $key => $row){
                        // $name = $row[0];
                        // $age = $row[1];
                        // $country = $row[2];

                        $username = $row[0];
                        $password = $row[1];
                        $name = $row[2];

                        // Checking that same username is not added twice (Preventing duplicacy)
                        $select_sql = "SELECT * FROM users WHERE username='$username'";
                        $selectResult = mysqli_query($conn, $select_sql);
                        $numOfRows = mysqli_num_rows($selectResult);
                        if($numOfRows > 0)
                        {
                            // Username already existing
                            // Do nothing
                        }
                        else
                        {
                            // Username does not exists and add the user in database
                            // Hashing the password of user
                            $group = $_POST['excelGroup'];
                            if($group == 'All')
                            {
                                // Add user only in 'All' group
                                $insertGroup = "INSERT INTO `groups` (`username`,`All`) VALUES ('$username','1')";
                                $insertGroupResult = mysqli_query($conn, $insertGroup);
                            }
                            else
                            {
                                // Add user in some other group also along with group'All'
                                $insertGroup = "INSERT INTO `groups` (`username`,`All`,`$group`) VALUES ('$username','1','1')";
                                $insertGroupResult = mysqli_query($conn, $insertGroup);
                            }
                            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                            $insert_sql = "INSERT INTO `users` (`username`, `password`, `name`) VALUES ('$username', '$hashPassword', '$name')";
                            mysqli_query($conn, $insert_sql);
                            header("location:addUser.php?added=1");
                        }
                    }
                }
                // End of processing of excel file

                require "../footer/footer.php";
            }
            else
            {
                // Admin not logged in 
                session_unset();
                session_destroy();
                header("location:../home/home.php");
            }
        }   
        else
        {
            header("location: ../index.php?login=1");
        }
        
        if(isset($_GET['ITSExists'])) {
            $message = "ITS Already Exists";
            require "../modal.php";
            echo "
                <script src='../home/jquery-3.7.0.min.js'></script>
                    <script>
                        $('#button').click();
                    </script>
                ";
        }

        if(isset($_GET['added'])) {
            $message = "Added Successfully";
            require "../modal.php";
            echo "
                <script src='../home/jquery-3.7.0.min.js'></script>
                    <script>
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
                    window.location.href = "l../navbarLinks/logoutHnadler.php?multipleLogin=1"
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> -->
    <script src="superAdminAndAdmin.js"></script>
  </body>
</html>