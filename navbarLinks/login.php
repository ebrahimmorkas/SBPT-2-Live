<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="loginHandler.php" method="post">
        <input type="text" name="ab" id="">
        <button type="submit">Save</button>
    </form>
</body>
</html>



<center>
                    <div style="width: 500px;" class="plyr__video-embed" id="player">
                        <iframe src="'.$link.'"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay">
                        </iframe>
                    </div>
                </center>


                <iframe width="560" height="315" src="https://www.youtube.com/embed/GMaRnORKk5A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                    https://youtu.be/GMaRnORKk5A

                    <iframe width="560" height="315" src="https://www.youtube.com/embed/lpKKVYqq-SA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>



                        for($i = 0 ; $i < count($arrayOfIndex) ; $i++)
                {
                    $server = $serverNames[$arrayOfIndex[$i]];
                    $selectServer = "SELECT * FROM `link` WHERE `$server`!=''";
                    $selectServerResult = mysqli_query($conn, $selectServer);
                    $rowOfServer = mysqli_fetch_assoc($selectServerResult);
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
                    echo $rowOfServer[$server];
                }
                echo '</div>';