<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Video Servers</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../home/home.css">
    <style>
        #hidden{
            display:none;
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
        // Getting the its of the currently logged in user to verify the logged user is admin or not
        $ITS=$_SESSION['username'];
        require("../databaseConnect.php");
        echo '<div id="hidden">';
        require "../detection.php";
        echo '</div>';
        $selectSql="SELECT * FROM admins WHERE username='$ITS'";
        $selectResult=mysqli_query($conn,$selectSql);
        // $row=mysqli_fetch_assoc($selectResult);
        $numOfRows = mysqli_num_rows($selectResult);
        function dropdown($server, $name)
        {
            require "../databaseConnect.php";
            echo '
            <div class="mb-3">
                <label for="group" class="form-label mt-3">Please select the group for '.$server.'</label>
                    <select class="form-select" name="'.$name.'" aria-label="Default select example">
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
            </div>';
  }
        if($numOfRows > 0)
        {
            echo '
                <div class="container">
                    <div class="text-center videoServersHeading">
                        <span id="heading2" class="text-center"><b>Video Servers</b></span> 
                    </div>
                    
                    <!-- <h4 class="text-center mb-3">If you are filling both the inputs then click any one <b>save</b> button </h4> -->
                </div>
                
                <div class="container mb-5" id="formContainerOfVideoServers">
                        <form class="my-3" method="POST" action="uploadVideoHandler.php">
                        ';
                        $select = "SELECT name FROM servers";
                        $result = mysqli_query($conn, $select);
                        $numberOfRows =  mysqli_num_rows($result);
                        if($numberOfRows == 0)
                        {
                            // Do nothing
                            echo '<center><h3>No servers to display</h3></center>';
                        }
                        else
                        {
                            // Video servers are present in database

                            // Creating the variable that will be used for name attribute in this form and after every iteration of while loop its value will be incremented
                            $i = 1;
                            while($rows = mysqli_fetch_assoc($result))
                            {
                                $value=$rows['name'];
                                echo '
                                <div class="my-3 linkInputs">
                                    <label for="'.$value.'" class="form-label"><b>'.$value.'</b></label>
                                    <div id="linkContainer">
                                        <input type="text" class="form-control" id="serverA" aria-describedby="emailHelp" name="'.$i.'">
                                    </div>
                                </div>';
                                $nameOfGroup = "group".strval($i);
                                dropdown($value,$nameOfGroup);
                                $i++;  
                            }
                            echo '
                            <center><button class="btn btn-primary mx-3 mt-3" id="">Save</button></center>
                            ';
                        }
                        echo '
                        </form>
                </div>
            ';
            require "../footer/footer.php";
        }
        else
        {
            // Adminn not login
            session_unset();
            session_destroy();
            header("location:../index.php");
        }
    }
    else
    {
        // Not login
        header("location:../index.php?login=1");
    }

    if(isset($_GET['videoUploaded']))
    {
        $message = "Video Uploaded Successfully";
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> -->
    <!-- <script src="uploadVideo.js"></script> -->
  </body>
</html>