<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>responsive footer design codepen</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style media="screen">
      *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    background: #fcfcfc;
    font-family: sans-serif;
}
footer{
    /* position: absolute;
    bottom: 0;
    left: 0;
    right: 0; */
    background: #111;
    height: auto;
    width: 100vw;

    padding-top: 40px;
    color: #fff;
}
.footer-content{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}
.footer-content h3{
    font-size: 2.1rem;
    font-weight: 500;
    text-transform: capitalize;
    line-height: 3rem;
}
.footer-content p{
    max-width: 500px;
    margin: 10px auto;
    line-height: 28px;
    font-size: 14px;
    color: #cacdd2;
}
.socials{
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1rem 0 3rem 0;
}
.socials li{
    margin: 0 10px;
}
.socials a{
    text-decoration: none;
    color: #fff;
    border: 1.1px solid white;
    padding: 5px;

    border-radius: 50%;

}
.socials a i{
    font-size: 1.1rem;
    width: 20px;


    transition: color .4s ease;

}
.socials a:hover i{
    color: aqua;
}

.footer-bottom{
    background: #000;
    width: 100vw;
    padding: 20px;
padding-bottom: 40px;
    text-align: center;
}
.footer-bottom p{
float: left;
    font-size: 14px;
    word-spacing: 2px;
    text-transform: capitalize;
}
.footer-bottom p a{
  color:#44bae8;
  font-size: 16px;
  text-decoration: none;
}
.footer-bottom span{
    text-transform: uppercase;
    opacity: .4;
    font-weight: 200;
}
.footer-menu{
  float: right;

}
.footer-menu ul{
  display: flex;
}
.footer-menu ul li{
padding-right: 10px;
display: block;
}
.footer-menu ul li a{
  color: #cfd2d6;
  text-decoration: none;
}
.footer-menu ul li a:hover{
  color: #27bcda;
}

@media (max-width:500px) {
.footer-menu ul{
  display: flex;
  margin-top: 10px;
  margin-bottom: 20px;
}
}
    </style>
</head>
<body>
    <footer>
        <?php
        echo' 
        <div class="footer-content">
            <h3>Foolish Developer</h3>
            <p>Raj Template is a blog website where you will find great tutorials on web design and development. Here each tutorial is beautifully described step by step with the required source code.</p>
            <ul class="socials">
                <!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                <li><a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJlHDsKlddnkfcPgDdSQZkDqhgPnLHrcthfzPtNwJCLVFxMktJFxHFXrZTHwKdwxHPFfWXV" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <!-- <li><a href="#"><i class="fa fa-youtube"></i></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li> -->
                <li><a href="https://www.instagram.com/ebrahimmm___/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#" data-bs-toggle="tooltip" data-bs-title="Default tooltip"><i class="fa fa-phone"></i></a></li>
                <!-- <li><a href="#"><i class="fa fa-github"></i></a></li> -->
                <li><a href="https://wa.me/8097744371" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                <li><a href="https://t.me/952481185" target="_blank"><i class="fa fa-telegram"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>copyright &copy; <a href="#">Foolish Developer</a>  </p>
                    <div class="footer-menu">
                      <ul class="f-menu">
                        <li><a href="">Home</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Contact</a></li>
                        <li><a href="">Blog</a></li>
                      </ul>
                    </div>
        </div>
    </footer>
    ';
?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>responsive footer design codepen</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style media="screen">
      /* *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    background: #fcfcfc;
    font-family: sans-serif;
} */
footer{
    /* position: absolute;
    bottom: 0;
    left: 0;
    right: 0; */
    background: #0e4653;
    height: auto;
    width: 100vw;
    padding-top: 40px;
    color: #fff;
    overflow-x: hidden;
    /* overflow-y: none; */
}
.footer-content{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
}
.footer-content h3{
    font-size: 2.1rem;
    font-weight: 500;
    text-transform: capitalize;
    line-height: 3rem;
}
.footer-content p{
    max-width: 500px;
    margin: 10px auto;
    line-height: 28px;
    font-size: 14px;
    color: #cacdd2;
}
.socials{
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1rem 0 3rem 0;
}
.socials li{
    margin: 0 10px;
}
.socials a{
    text-decoration: none;
    color: #fff;
    border: 1.1px solid white;
    padding: 5px;

    border-radius: 50%;

}
.socials a i{
    font-size: 1.1rem;
    width: 20px;


    transition: color .4s ease;

}
.socials a:hover i{
    color: aqua;
}

.footer-bottom{
    background: #000;
    width: 100vw;
    padding: 20px;
padding-bottom: 40px;
    text-align: center;
    /* overflow-x: hidden; */
}
.footer-bottom p{
float: left;
    font-size: 14px;
    word-spacing: 2px;
    text-transform: capitalize;
}
.footer-bottom p a{
  color:#44bae8;
  font-size: 16px;
  text-decoration: none;
}
.footer-bottom span{
    text-transform: uppercase;
    opacity: .4;
    font-weight: 200;
}
.footer-menu{
  float: right;

}
.footer-menu ul{
  display: flex;
}
.footer-menu ul li{
padding-right: 10px;
display: block;
}
.footer-menu ul li a{
  color: #cfd2d6;
  text-decoration: none;
}
.footer-menu ul li a:hover{
  color: #27bcda;
}

@media (max-width:500px) {
.footer-menu ul{
  display: flex;
  margin-top: 10px;
  margin-bottom: 20px;
}
}
    </style>
</head>
<body>
    <footer>
        <?php
        echo' 
        <div class="footer-content mt-auto">
            <h3>SBPT-2 WEBSITE</h3>
            <p>This webste is designed to conduct all the events and majlis online which were conducted offline down in the colony due to rain.</p>
            <h4>CONTACT DEVELOPER</h4>
            <ul class="socials">
                <!-- <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                <li><a href="https://mail.google.com/mail/u/0/#inbox?compose=CllgCJlHDsKlddnkfcPgDdSQZkDqhgPnLHrcthfzPtNwJCLVFxMktJFxHFXrZTHwKdwxHPFfWXV" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <!-- <li><a href="#"><i class="fa fa-youtube"></i></a></li> -->
                <!-- <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li> -->
                <li><a href="https://www.instagram.com/ebrahimmm___/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#" data-bs-toggle="tooltip" data-bs-title="Default tooltip"><i class="fa fa-phone"></i></a></li>
                <!-- <li><a href="#"><i class="fa fa-github"></i></a></li> -->
                <li><a href="https://wa.me/8097744371" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                <li><a href="https://t.me/952481185" target="_blank"><i class="fa fa-telegram"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>copyright &copy; <a href="">Ebrahim Morkas</a>  </p>
                    <div class="footer-menu">
                      <ul class="f-menu">
                        <li><a href="home/home.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <!-- <li><a href="">Contact</a></li>
                        <li><a href="">Blog</a></li> ->
                      </ul>
                    </div>
        </div>
    </footer>
    ';
?>
</body>
</html>
