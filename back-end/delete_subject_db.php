<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

<?php
session_start();
include('../config.php');

if (isset($_GET["sub_id"])) {
    $subid = $_GET["sub_id"];
    $sql = "DELETE FROM tb_subject WHERE sub_id = '$subid'";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        $_SESSION['delete'] = "ลบข้อมูลสำเร็จ";
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'ลบข้อมูลสำเร็จ',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../master/table_subject.php';
                });
              </script>";
    }
} else {
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'ไม่พบไอดี',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../master/table_subject.php';
            });
          </script>";
    exit();
}

?>