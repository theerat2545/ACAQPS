<?php
session_start();
include('../config.php');

if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM tb_examdetail WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
    }
} 


if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM tb_correct_answer WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
    }
} 

if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM item_counts WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
    }
}

if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM result_reliability WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
    }
}

if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM tb_answer WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
    }
} 

if (isset($_GET["id_exam"])) {
    $id = $_GET["id_exam"];
    $sql = "DELETE FROM tb_exam WHERE id_exam = '$id'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
        header("location: ../master/table_exam.php");
    }
} else {
    echo "<script>alert('ไม่พบไอดี');</script>";
    echo "<script>window.location.href = '../master/table_exam.php';</script>";
    exit();
}
?>