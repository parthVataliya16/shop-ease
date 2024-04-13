<?php
    session_start();
    unset($_SESSION['user']);
    header("location: ./views/auth/signin.php");
?>