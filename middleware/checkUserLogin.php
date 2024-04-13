<?php
    session_start();

    function loginSuccessfully($role = 'user'): bool
    {
        if ($role == 'admin') {
            return isset($_SESSION['user']) && $_SESSION['user'] == 'admin';
        } else {
            return isset($_SESSION['user']) && $_SESSION['user'] != 'admin';
        }
    }
?>