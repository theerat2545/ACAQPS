<?php
session_start();
include('../config.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM tb_userandsubject WHERE us_id = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
        header("location: ../master/manage_user.php");
    }
} 

?>