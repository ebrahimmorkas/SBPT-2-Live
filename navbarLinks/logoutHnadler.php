<?php
    session_start();
    session_unset();
    session_destroy();
    if(isset($_GET['multipleLogin']))
    {
        header("location:../index.php?multipleLogin=1");
    }
    else
    {
        header("location:../index.php");
    }
?>