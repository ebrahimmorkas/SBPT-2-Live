<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <link rel="stylesheet" href="home1.css">
    <link rel="stylesheet" href="youtube.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.css" />
    <style>
        #hidden{
            display:none;
        }
    </style>
  </head>
  <body class="d-flex flex-column vh-100">
    <?php
        session_start();
        if(isset($_SESSION['login']))
        {
            require "../databaseConnect.php";
            // require "../navbar/navbar.php";
            // require "../navbar/navbar1.php";
            require "../navbar/navbar2.php";
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            echo '
            <div class="container">
                <!-- <div class="text-center mt-3"></div>
                <div class="text-center heading">
                    <span id="heading1" class="text-center"><b>Server A (Audio and Video)</b></span> 
                </div> -->';
            $mainId = 0;
            $notEmpty = 0;
            $groupNames = array();
            $serverNames = array();
            $links = array();
            $selectSql = "SELECT name FROM servers";
            $selectResult = mysqli_query($conn, $selectSql);
            $numOfRows = mysqli_num_rows($selectResult);
            if($numOfRows)
            {
                // Servers are present
                while($rowsOfServersTable = mysqli_fetch_assoc($selectResult))
                {
                    $sql = "SHOW COLUMNS FROM `link`";
                    $result = mysqli_query($conn,$sql);

                    $selectFromLink = "SELECT * FROM link";
                    $selectFromLinkResult = mysqli_query($conn, $selectFromLink);
                    $numOfRowsOfLink = mysqli_num_rows($selectFromLinkResult);

                    // while($row = mysqli_fetch_array($result))
                    // {

                    // }
                    while($rowsOfLinkTable = mysqli_fetch_assoc($selectFromLinkResult))
                    {
                        $notEmpty = 0;   
                        $serverName = $rowsOfServersTable['name'];
                        if($rowsOfLinkTable["$serverName"] != "")
                        {
                            $notEmpty = 1;
                            array_push($serverNames, $serverName);
                            array_push($links, $rowsOfLinkTable["$serverName"]);
                        }
                        
                        if($notEmpty == 1)
                        {
                            $name = $rowsOfLinkTable["$serverName"];
                            $selectGroupFromLink = "SELECT * FROM link WHERE `$serverName`='$name'";  
                            $selectGroupFromLinkResult = mysqli_query($conn, $selectGroupFromLink);

                            $rowsOfGroupFromLink = mysqli_fetch_assoc($selectGroupFromLinkResult);
                            
                                $select = "SHOW COLUMNS FROM `groups`";
                                $result = mysqli_query($conn, $select);
                                while($rowOfColumn = mysqli_fetch_array($result))
                                {
                                    // echo "Hello".$rowOfColumn['Field']."<br>";
                                    if($rowOfColumn['Field'] == 'id' || $rowOfColumn['Field'] == 'username')
                                    {
                                        // Do nothing
                                    }
                                    else
                                    {
                                        $r = $rowOfColumn['Field'];
                                        $s = "SELECT * FROM `link` WHERE `$serverName`='$name' AND `$r`='1'";
                                        $sr = mysqli_query($conn, $s);
                                        $n = mysqli_num_rows($sr);
                                        if($n>0)
                                        {
                                            // echo $r."<br>".$serverName."<br>".$name."<br>";
                                            array_push($groupNames, $r);
                                            break;
                                        }
                                        else
                                        {
                                            // Do nothing
                                        }
                                        // echo "Outside $r <br>$serverName<br>";
                                        // }
                                    }
                                } // End of while loop 
                            //   echo "Iteration<br>";
                        }
                    } // End of while loop
                } // End of all while loop
                // echo $groupName;
                echo "Server Names    ";
                print_r($serverNames);
                echo "<br>";
                echo "Links     ";
                print_r($links);
                echo "<br>";
                echo "Group Names     ";
                print_r($groupNames);
                echo "<br>";

                // Logic for displaying the video
                $username = $_SESSION['username'];

                // In this array we will store the groups in which user is added
                $userAddedInGroups = array();

                $selectGroup = "SELECT * FROM `groups` WHERE `username`='$username'"; 
                $selectGroupResult = mysqli_query($conn, $selectGroup);
                $rowsFromGroupTable = mysqli_fetch_assoc($selectGroupResult);

                $selectColumnFromGroupTable = "SHOW COLUMNS FROM `groups`";
                $selectColumnFromGroupTableResult = mysqli_query($conn, $selectColumnFromGroupTable);
                
                while($rowsOfGroupTable = mysqli_fetch_array($selectColumnFromGroupTableResult))
                {
                    if($rowsOfGroupTable['Field'] == 'id' || $rowsOfGroupTable['Field'] == 'username')
                    {
                        // Do nothing
                    }
                    else
                    {
                        if($rowsFromGroupTable[$rowsOfGroupTable['Field']] == 1)
                        {
                            array_push($userAddedInGroups, $rowsOfGroupTable['Field']);
                        }
                    }
                }
                echo "User present in groups       ";
                print_r($userAddedInGroups);
                echo "<br>";

                // In this array we will store the common values from $userAddedInGroups and $groupNames that means in this array the groups will be added in which there is server
                $availableGroups = array();

                // Creating logic for removing the common groups between the two arrays
                for($i = 0 ; $i < count($userAddedInGroups) ; $i++)
                {
                    for($j = 0 ; $j < count($groupNames) ; $j++)
                    {
                        if($groupNames[$j] == $userAddedInGroups[$i])
                        {
                            array_push($availableGroups, $groupNames[$j]);
                        }
                    }
                }
                echo "Common groups     ";
                print_r($availableGroups);
                echo "<br>";

                // Logic to find the index of Groups from groupNames accodrding to the elements present in the availableGroups
                $arrayOfIndex = array();
                for($i= 0 ; $i < count($groupNames) ; $i++)
                {
                    for($j = 0 ; $j < count($availableGroups) ; $j++)
                    {
                        if($groupNames[$i] == $availableGroups[$j])
                        {
                            array_push($arrayOfIndex, $i);
                        }
                    }
                }
                echo "Index of Common groups      ";
                print_r($arrayOfIndex);
                echo "<br>";

                function youtube($link)
                {
                    echo '
                    <div style="width: 500px;" class="plyr__video-embed" id="player">
                        <iframe src="'.$link.'"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay">
                        </iframe>
                    </div>
                    ';
                }

                // Paste Here

                // Checking whether admin is logged in. If yes then he should have access to all servers using buttons
                $selectAdmin = "SELECT * FROM `admins` WHERE `username`='$username'";
                $selectAdminResult = mysqli_query($conn,$selectAdmin);
                $numberOfAdminRows = mysqli_num_rows($selectAdminResult);
                if($numberOfAdminRows > 0)
                {
                    $id = "server";
                    $adminLink= $links[$_SESSION['server']];
                    $adminServer = $serverNames[$_SESSION['server']];
                    echo '
                        <div class="text-center mt-3"></div>
                        <div class="text-center heading">
                            <span id="heading1" class="text-center"><b>'.$adminServer.'</b></span> 
                        </div>
                        <div class="container">
                            <center>
                                <div style="width: 500px;" class="plyr__video-embed" id="player">
                                    <iframe src="'.$adminLink.'"
                                        allowfullscreen
                                        allowtransparency
                                        allow="autoplay">
                                    </iframe>
                                </div>
                            <center>
                        </div>
                    ';
                    echo '<div class="d-flex justify-content-around my-3" id="serversButtons">';
                    for($i=0; $i<count($serverNames); $i++)
                    {
                        $mainId = strval($i);
                        echo'
                        <a type="button" class="btn btn-primary btn-lg serversBtn custom-button" id="'.$mainId.'" href="selectServer.php?id='.$mainId.'">'.$serverNames[$i].'</a>
                        ';
                    }
                    echo '</div>';
                }
                else
                {
                    // Checking whether admin had added more than one group 
                    if(count($availableGroups) == 1)
                    {
                        // Only one group is added
                        $server = $serverNames[$arrayOfIndex[0]];
                        $selectServer = "SELECT * FROM `link` WHERE `$server`!=''";
                        $selectServerResult = mysqli_query($conn, $selectServer);
                        $rowOfServer = mysqli_fetch_assoc($selectServerResult);
                        // Query to see that both audio and video is present in server
                        $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$server'";
                        $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                        $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);
                        if($selectServerOptionRow['video'] == 1)
                        {
                            // Both Audio and Video is present       
                            echo '
                            <div class="text-center mt-3"></div>
                            <div class="text-center heading">
                                <span id="heading1" class="text-center"><b>'.$server.'</b></span> 
                            </div>
                            <center>';
                                youtube($rowOfServer[$server]);
                            echo '
                            </center>
                        ';
                        }
                        else
                        {
                            // Only audio is present
                            echo "Only Audio<br>";
                        }
                    }
                    else
                    {
                        // There are more than group but display only other groups leaving `all`
                        for($i = 0 ; $i < count($arrayOfIndex) ; $i++)
                        {
                            if($availableGroups[$arrayOfIndex[$i]] == 'All')
                            {
                                // Do nothing
                            }
                            else
                            {
                                // Variable that will hold the index of first group added in array rather than group `all`
                                $index = $arrayOfIndex[$i];
                                // Variable that will hold server name
                                $sName = $serverNames[$index];
                                // Variable that will hold group name
                                $gName = $groupNames[$index];
                                // Variable that will hold the link
                                $lName = $links[$index];
                                $selectServer = "SELECT * FROM `link` WHERE `$sName`!=''";
                                $selectServerResult = mysqli_query($conn, $selectServer);
                                $rowOfServer = mysqli_fetch_assoc($selectServerResult);

                                // Query to see that both audio and video is present in server
                                $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$sName'";
                                $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                                $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);
                                if($selectServerOptionRow['video'] == 1)
                                {
                                    // Both Audio and Video is present       
                                    echo '
                                    <div class="text-center mt-3"></div>
                                    <div class="text-center heading">
                                        <span id="heading1" class="text-center"><b>'.$sName.'</b></span> 
                                    </div>
                                    <center>';
                                        youtube($rowOfServer[$sName]);
                                    echo '
                                    </center>
                                ';
                                }
                                else
                                {
                                    // Only audio is present
                                    echo "Only Audio<br>";
                                }
                                break;
                            }
                        }
                    }
                }
                echo '</div>';
            }
            else
            {
                // No servers
                echo "Nothing to display";
            }
            // echo '
            // <script>
            // for(let i = 0 ; i < '.count($serverNames).' ; i++)
            // {
            //     document.getElementById("'.$mainId.'").addEventListener("click", function(e){
            //         e.preventDefault();
            //         window.alert("Hello'.$mainId.'");
            //     })
            // }
            // </script>
            // ';

            // echo '
            // <script>
            //     while(true)
            //     {
            //         let id = '.$mainId.';
            //         $(document).ready(function() {
            //             $(".submit").click(function(e) {
            //                 $.ajax({
            //                     type: "POST",
            //                     url: "selectServer.php",
            //                     data: {name: }
            //                 })
            //             })
            //         })
            //     }
            // </script>
            // ';
            // echo '
            // <script>
            // let serversButtons = document.querySelectorAll(".serversBtn");
            // for(let i = 0 ; i < serversButtons.length ; i++)
            // {
            //     let btnId = serversButtons[i].id;
            //     serversButtons[i].addEventListener("click", function(){
            //         // alert("Hello " + this.innerText);
            //         $.ajax({
            //             type: "POST",
            //             url: "selectServer.php",
            //             data: {sName : $(`#${btnId}`)},
            //             success: function(res, status, xhr)
            //             {
            //                 $("#s").html(result);
            //             }
            //         });
            //     })
            // }
            // </script>
            // ';
            require "../footer.php";
        }
        else
        {
            header("location:../index.php?login=1");
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
                    window.location.href = "logout.php"
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);
    </script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="youtube.js"></script>
    <script src="jquery-3.7.0.min.js"></script>
    <script src="adminServers.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.js"></script>
  </body>
</html>
