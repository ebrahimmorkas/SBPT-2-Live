<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact</title>
    <link rel="icon" href="../websiteLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <style>
        #hidden{
            display:none;
        }

        .jumbo-width{
            opacity: 85%;
            border-radius: 45px;
            padding-bottom: 3vh;
            padding-top: 3vh;
            margin: 6vh;
            background-color: #0e4653;
            width: 58vw;
            color: white;
        }

        .mail{
            color: #caced1 !important;
            text-decoration: none;
            font-size: 25px;
        }

        @media screen and (max-width: 578px) {
        .mail {
            padding: 3vh 0px 3vh;
            display:flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        }

        @media screen and (max-width:638px) {
        .number {
            text-align: center;
        }
        }

        .icons{
            margin: 25px 0px 1px 0px;
        }

        .h1-color{
            color: #caced1 !important;
        }
    </style>

    
    <!-- <link rel="stylesheet" href="../footer/footer.css"> -->
  </head>
  <body class="d-flex flex-column vh-100">
    <?php
        session_start();
        if(isset($_SESSION['login'])) 
        {
            require("../navbar/navbar.php");
            echo '<div id="hidden">';
            require "../detection.php";
            echo '</div>';

            echo '<center><div class="container">
                    <div class="jumbotron jumbo-width">
                        <h1 class="display-4 h1-color">Connect with us </h1>

                        <div class="icons">
                            <a class="mail" href="mailto:morkasebrahim3@gmail.com">
                                <i class="fa fa-google-plus"></i>
                                <span class="px-3 mobile">Gmail</span>
                            </a>
                        </div>

                        <div class="icons">
                            <a class="img-fluid mail py-4" width="25" href="https://www.instagram.com/ebrahimmm___/" target="_blank">
                            <i class="fa fa-instagram"></i>
                            <span class="px-3 mobile">Instagram</span>
                            </a>
                        </div>

                        <div class="icons">
                            <a class="img-fluid mail px-2" width="25" href="https://wa.me/8097744371" target="_blank">
                                <i class="fa fa-whatsapp"></i>
                                <span class="px-3 mobile">Whatsapp</span>
                            </a>
                        </div>

                        <div class="icons">
                            <a class="img-fluid mail px-2" width="25">
                                <i class="fa fa-phone"></i>
                                <span class="px-3 mobile">Call us at +91-<span class="number">9082507608</span>
                            </a>
                        </div>
                    </div>
                </div></center>
            ';
            require "../footer/footer.php";
        }
        else
        {
            header("location:../index.php?login.php");
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