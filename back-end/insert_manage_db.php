<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
<?php
include ("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysqli_escape_string($conn, $_POST['user']); // ต้องเปลี่ยนจาก 'user_id' เป็น 'user'
    $sub_id = mysqli_escape_string($conn, $_POST['sub']); // ต้องเปลี่ยนจาก 'id' เป็น 'sub'
    $subid = mysqli_escape_string($conn, $_POST['subid']); // ต้องเปลี่ยนจาก 'subjectID' เป็น 'subid'
    $subname = mysqli_escape_string($conn, $_POST['subname']); // ต้องเปลี่ยนจาก 'subjectName' เป็น 'subname'

    $checkSql = "SELECT sub_id FROM tb_userandsubject WHERE sub_id = '$sub_id'";

    
    $insertSql = "INSERT INTO tb_userandsubject (user_id, sub_id, subjectID, subjectName) VALUE ('$user_id','$sub_id','$subid','$subname')";
    if ($conn->query($insertSql) === TRUE) {
        echo "<script>
                Swal.fire({
                    title: 'สร้างไอดีการประมวลผลรายวิชาสำเร็จ',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../master/manage_user.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
    
    }


?>