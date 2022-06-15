<?php
    session_start();
    unset($_SESSION["sid"]);
    unset($_SESSION["spwd"]);
    header("Location:login.html");
?>
