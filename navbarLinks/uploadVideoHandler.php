<?php
    session_start();
    if(isset($_SESSION['login']))
    {
        // Getting the ITS of currently logged in Admin
        $ITS=$_SESSION['username'];
        require("../databaseConnect.php");
        $selectSql="SELECT * FROM admins WHERE username='$ITS'";
        $selectResult=mysqli_query($conn,$selectSql);
        // $row=mysqli_fetch_assoc($selectResult);
        $numOfRows = mysqli_num_rows($selectResult);

        if($numOfRows > 0)
        {
            // Admin had logged in 
            if($_SERVER['REQUEST_METHOD']=='POST')
            {
                // Write logic here
                
                // Creating the array that will hold the servers name
                $serversName = array();
                
                $selectServers = "SELECT name FROM `servers`";
                $selectServersResult = mysqli_query($conn, $selectServers);
                while($rows = mysqli_fetch_assoc($selectServersResult))
                {
                    array_push($serversName, $rows['name']);
                }

                // Length of array
                $length = count($serversName);

                $deleteSql = "DELETE FROM link";
                $deleteResult = mysqli_query($conn, $deleteSql);
                for($i=1; $i<=$length; $i++)
                {
                    // See the uploadVideo.php file to know why we are using $i as name attribute
                    $server = $_POST["$i"];
                    $groupName = 'group'.strval($i);
                    $group = $_POST["$groupName"];
                    $arrayIndex = $i - 1;
                    $insertSql = "INSERT INTO `link` (`id`, `$serversName[$arrayIndex]`, `$group`) VALUES ('$i', '$server', '1')";
                    $insertSqlResult = mysqli_query($conn, $insertSql);
                    header("location:uploadVideo.php?videoUploaded=1");
                }
            }
            else
            {
                // tried to access the page without filling the form
                header("location:uploadVideo.php");
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
        // Not login
        header("location:../index.php");
    }
?>