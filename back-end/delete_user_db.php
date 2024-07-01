<?php
session_start();
include('../config.php');

if (isset($_GET["user_id"])) {
    $uid = $_GET["user_id"];
    $sql = "DELETE FROM tb_user WHERE user_id = '$uid'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
        header("location: ../master/table_users.php");
    }
} 

?>