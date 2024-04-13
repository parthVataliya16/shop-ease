<?php
if (!isset($_SESSION['user'])) {
    if (basename($_SERVER['PHP_SELF']) != 'signin.php') {
        header('location: http://localhost/practice/project/views/auth/signin.php');
        exit;
    }
} else {
    if ($_SESSION['user'] == 'admin') {
        header('location: http://localhost/practice/project/views/admin/dashboard.php');
        exit;
    } else {
        header('location: http://localhost/practice/project/views/users/index.php');
        exit;
    }
}

?>