<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>  
<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = trim($_POST['userid']);
    $username = $_POST['email'];
    $password = $_POST['password'];
    $pass = md5($password); // แนะนำให้ใช้วิธีการเข้ารหัสที่มีความปลอดภัยมากกว่าแบบ MD5

    $sql = "UPDATE tb_user SET user_username='$username', user_password='$pass' WHERE user_id='$userId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        // การอัปเดตสำเร็จ
        echo json_encode(["status" => "success"]);

        // แสดงข้อความด้วย SweetAlert2
        echo "<script>
                Swal.fire({
                    title: 'แก้ไขรหัสผ่านสำเร็จ',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../profile.php';
                });
              </script>";
    } else {
        // การอัปเดตไม่สำเร็จ
        echo json_encode(["status" => "error"]);

        // แสดงข้อความด้วย SweetAlert2
        echo "<script>
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถแก้ไขรหัสผ่านได้',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
