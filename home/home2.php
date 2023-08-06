<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="home1.css">
    <link rel="stylesheet" href="youtube.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/CDNSFree2/Plyr/plyr.css" />
    <link rel="stylesheet" href="../footer/footer.css">
    <style>
        #hidden{
            display:none;
        }

        #onlyAudio .plyr__video-embed {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%; /* 16:9 aspect ratio (adjust as needed) */
        overflow: hidden;
        background-color: black;
        }

        #onlyAudio .plyr__video-embed iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0; /* Hide the iframe */
        }

        .plyr__embed-video .ytp-title-link,
    .plyr__embed-video .ytp-watermark,
    .plyr__embed-video .ytp-chrome-bottom,
    .plyr__embed-video .ytp-gradient-bottom {
      display: none !important;
    }
    </style>
    <script src="https://cdn.plyr.io/3.5.6/plyr.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', () => {
                const controls = [
                'play-large', // The large play button in the center
                'play', // Play/pause playback
                'progress', // The progress bar and scrubber for playback and buffering
                'current-time', // The current time of playback
                'duration', // The full duration of the media
                'mute', // Toggle mute
                'volume', // Volume control
                'captions', // Toggle captions
                'airplay', // Airplay (currently Safari only)
                'pip', // Picture-in-picture (currently Safari only)
                'fullscreen' // Toggle fullscreen
            ];
            const player = Plyr.setup('.js-playerOnlyAudio', { controls });
        });
    </script>
    <script>
            document.addEventListener('DOMContentLoaded', () => {
                const controls = [
                'play-large', // The large play button in the center
                'play', // Play/pause playback
                'progress', // The progress bar and scrubber for playback and buffering
                'current-time', // The current time of playback
                'duration', // The full duration of the media
                'mute', // Toggle mute
                'volume', // Volume control
                'captions', // Toggle captions
                'airplay', // Airplay (currently Safari only)
                'pip', // Picture-in-picture (currently Safari only)
                'fullscreen' // Toggle fullscreen
            ];
            const player = Plyr.setup('.js-player', { controls });
        });
    </script>
  </head>
  <body class="d-flex flex-column vh-100">
  <?php
        session_start();
        if(isset($_SESSION['login']))
        {
            require "../databaseConnect.php";
            // require "../navbar/navbar.php";
            // require "../navbar/navbar1.php";
            // require "../navbar/navbar2.php";
            require "../navbar/navbar1.php";
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';
            echo '<div class="container">
            </div>';
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
                }
            }// End of all while loop
                // echo $groupName;
                // echo "Server Names    ";
                // print_r($serverNames);
                // echo "<br>";
                // echo "Links     ";
                // print_r($links);
                // echo "<br>";
                // echo "Group Names     ";
                // print_r($groupNames);
                // echo "<br>";

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
                // echo "User present in groups       ";
                // print_r($userAddedInGroups);
                // echo "<br>";

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
                // echo "Common groups     ";
                // print_r($availableGroups);
                // echo "<br>";

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
                // echo "Index of Common groups      ";
                // print_r($arrayOfIndex);
                // echo "<br>";

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

                // Function that will display both audio and video
                function youtubeVideoAndAudio($videoid)
                {
                    echo '
                        <center>
                            <div style="width: 500px;">
                                <div class="js-player" data-plyr-provider="youtube" data-plyr-embed-id="'.$videoid.'">
                                </div>
                            </div>
                        </center>
                    ';
                }

                // Function that will play only audio and not video
                function youtubeOnlyAudio($videoid)
                {
                    echo '
                        <center>
                            <div style="width: 500px;" id="onlyAudio">
                                <div class="js-playerOnlyAudio" data-plyr-provider="youtube" data-plyr-embed-id="'.$videoid.'">
                                </div>
                            </div>
                        </center>
                    ';
                }

                // Function that will extract only `youtube id of video` if the video is `live` video if video is `uploaded` video than we wont require this function
                function extractVideoIDofLiveVideo($link1)
                {
                    // https://youtube.com/live/FmDi7rvkuOw?feature=share
                    $ID = substr($link1, 25, 11);
                    return $ID;
                }
                // Function that will extract only `youtube id of video` if the video is `uploaded` video if video is `live` video than we wont require this function
                function extractVideoID($link1)
                {
                    $ID = substr($link1, 17, 11);
                    return $ID;
                }

                $selectAdmin = "SELECT * FROM `admins` WHERE `username`='$username'";
                $selectAdminResult = mysqli_query($conn,$selectAdmin);
                $numberOfAdminRows = mysqli_num_rows($selectAdminResult);
                if($numberOfAdminRows > 0)
                {
                    $id = "server";
                    $adminLink= $links[$_SESSION['server']];
                    $adminServer = $serverNames[$_SESSION['server']];
                    
                    for($i=0; $i<count($serverNames); $i++)
                    {
                        $server = $serverNames[$i];
                        echo '<div class="text-center mt-3"></div>
                        <div class="text-center heading">
                            <span id="heading1" class="text-center"><b>'.$server.'</b></span> 
                        </div>';

                        // Query to select the link from `link` table
                        $selectServer = "SELECT * FROM `link` WHERE `$server`!=''";
                        $selectServerResult = mysqli_query($conn, $selectServer);
                        $rowOfServer = mysqli_fetch_assoc($selectServerResult);

                        // Fetching the link from $rowOfServer
                        $link = $rowOfServer[$server];

                        // Query to see that both audio and video is present in server
                        $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$server'";
                        $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                        $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);

                        if($selectServerOptionRow['video'] == 1)
                        {
                            // Both Audio and Video is present
                            if(str_contains($link, 'live'))
                            {
                                // Video is live video
                                $videoID = extractVideoIDofLiveVideo($link);
                                youtubeVideoAndAudio($videoID);
                            }
                            else
                            {
                                // Video is not live
                                $videoID = extractVideoID($link);
                                youtubeVideoAndAudio($videoID);
                            }
                        }
                        else
                        {
                            // Only audio is present
                            if(str_contains($link, 'live'))
                            {
                                // Video is live video
                                $videoID = extractVideoIDofLiveVideo($link);
                                youtubeOnlyAudio($videoID);
                            }
                            else
                            {
                                // Video is not live
                                $videoID = extractVideoID($link);
                                youtubeOnlyAudio($videoID);
                            }
                        }
                    }
                }
                else
                {
                    for($i = 0 ; $i < count($arrayOfIndex) ; $i++)
                    {
                        $index = $arrayOfIndex[$i];
                        $userServerName = $serverNames[$index];
                        echo '<div class="text-center mt-3"></div>
                        <div class="text-center heading">
                            <span id="heading1" class="text-center"><b>'.$serverNames[$index].'</b></span> 
                        </div>';

                        // Query to select the link from `link` table
                        $selectServer = "SELECT * FROM `link` WHERE `$userServerName`!=''";
                        $selectServerResult = mysqli_query($conn, $selectServer);
                        $rowOfServer = mysqli_fetch_assoc($selectServerResult);

                        // Fetching the link from $rowOfServer
                        $link = $rowOfServer[$userServerName];                        

                        // Query to see that both audio and video is present in server
                        $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$userServerName'";
                        $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                        $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);

                        if($selectServerOptionRow['video'] == 1)
                        {
                            // Both Audio and Video is present
                            if(str_contains($link, 'live'))
                            {
                                // Video is live video
                                $videoID = extractVideoIDofLiveVideo($link);
                                youtubeVideoAndAudio($videoID);
                            }
                            else
                            {
                                // Video is not live
                                $videoID = extractVideoID($link);
                                youtubeVideoAndAudio($videoID);
                            }
                        }
                        else
                        {
                            // Only audio is present
                            if(str_contains($link, 'live'))
                            {
                                // Video is live video
                                $videoID = extractVideoIDofLiveVideo($link);
                                youtubeOnlyAudio($videoID);
                            }
                            else
                            {
                                // Video is not live
                                $videoID = extractVideoID($link);
                                youtubeOnlyAudio($videoID);
                            }
                        }
                    }
                }
                // Dont remove this its not the mistake
                echo '<div class="mb-5"></div>';
                // else
                // {
                //     // Checking whether admin had added more than one group 
                //     if(count($availableGroups) == 1)
                //     {
                //         // Only one group is added
                //         $server = $serverNames[$arrayOfIndex[0]];
                //         $selectServer = "SELECT * FROM `link` WHERE `$server`!=''";
                //         $selectServerResult = mysqli_query($conn, $selectServer);
                //         $rowOfServer = mysqli_fetch_assoc($selectServerResult);
                //         // Query to see that both audio and video is present in server
                //         $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$server'";
                //         $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                //         $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);
                //         if($selectServerOptionRow['video'] == 1)
                //         {
                //             // Both Audio and Video is present       
                //             echo '
                //             <div class="text-center mt-3"></div>
                //             <div class="text-center heading">
                //                 <span id="heading1" class="text-center"><b>'.$server.'</b></span> 
                //             </div>
                //             <center>';
                //                 youtube($rowOfServer[$server]);
                //             echo '
                //             </center>
                //         ';
                //         }
                //         else
                //         {
                //             // Only audio is present
                //             echo "Only Audio<br>";
                //         }
                //     }
                //     else
                //     {
                //         // There are more than group but display only other groups leaving `all`
                //         for($i = 0 ; $i < count($arrayOfIndex) ; $i++)
                //         {
                //             if($availableGroups[$arrayOfIndex[$i]] == 'All')
                //             {
                //                 // Do nothing
                //             }
                //             else
                //             {
                //                 // Variable that will hold the index of first group added in array rather than group `all`
                //                 $index = $arrayOfIndex[$i];
                //                 // Variable that will hold server name
                //                 $sName = $serverNames[$index];
                //                 // Variable that will hold group name
                //                 $gName = $groupNames[$index];
                //                 // Variable that will hold the link
                //                 $lName = $links[$index];
                //                 $selectServer = "SELECT * FROM `link` WHERE `$sName`!=''";
                //                 $selectServerResult = mysqli_query($conn, $selectServer);
                //                 $rowOfServer = mysqli_fetch_assoc($selectServerResult);

                //                 // Query to see that both audio and video is present in server
                //                 $selectServerOptions = "SELECT * FROM `servers` WHERE `name`='$sName'";
                //                 $selectServerOptionsResult = mysqli_query($conn, $selectServerOptions);
                //                 $selectServerOptionRow = mysqli_fetch_assoc($selectServerOptionsResult);
                //                 if($selectServerOptionRow['video'] == 1)
                //                 {
                //                     // Both Audio and Video is present       
                //                     echo '
                //                     <div class="text-center mt-3"></div>
                //                     <div class="text-center heading">
                //                         <span id="heading1" class="text-center"><b>'.$sName.'</b></span> 
                //                     </div>
                //                     <center>';
                //                         youtube($rowOfServer[$sName]);
                //                     echo '
                //                     </center>
                //                 ';
                //                 }
                //                 else
                //                 {
                //                     // Only audio is present
                //                     echo "Only Audio<br>";
                //                 }
                //                 break;
                //             }
                //         }
                //     }
                // }
                echo '</div>';
                
        }else
        {
            // No servers
            echo "Nothing to display";
        }
        
        // require "../footer/footer.php";

        // Script that will disable the devtools
        // require "../disableDevTools.php";
        
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>