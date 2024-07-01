<?php
session_start();

if (isset($_SESSION['user_level'])) {
    session_unset();
    session_destroy();
    header("location: ../login.php");
} else {
    header("location: ../home.php");
}
?>
