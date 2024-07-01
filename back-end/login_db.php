<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

<?php
session_start();
include('../config.php');

/*$errors = array();*/


// ตรวจสอบการส่งแบบฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordenc = md5($password);

    // สร้างคำสั่ง SQL เพื่อเลือกข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT * FROM tb_user WHERE user_username = '$email' AND user_password = '$passwordenc'";
    $result = $conn->query($sql);

    // ตรวจสอบว่าพบผู้ใช้ในฐานข้อมูลหรือไม่
    if ($result->num_rows > 0) {

        $row = mysqli_fetch_array($result);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_username'] = $row['user_username'];
        $_SESSION['user_prefix'] = $row['user_prefix'];
        $_SESSION['user_firstname'] = $row['user_firstname'];
        $_SESSION['user_lastname'] = $row['user_lastname'];
        $_SESSION['user_level'] = $row['user_level'];
        
        $_SESSION['user_name'] = $_SESSION['user_prefix'] . $_SESSION['user_firstname'] . "  " . $_SESSION['user_lastname'];


        if ($_SESSION['user_level'] == 'master') {
            echo "<script>
                    Swal.fire({
                        title: 'เข้าสู่ระบบสำเร็จ',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '../master/dashboard.php';
                    });
                  </script>";
        }
        if ($_SESSION['user_level'] == 'member') {
            echo "<script>
                    Swal.fire({
                        title: 'เข้าสู่ระบบสำเร็จ',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '../home.php';
                    });
                  </script>";
        }
    } else {
        // ผู้ใช้ไม่ถูกพบ แสดงข้อความผิดพลาดหรือทำการตรวจสอบอื่น ๆ
        echo "<script>
                Swal.fire({
                    title: 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../login.php';
                });
              </script>";
        exit();
    }
}


$conn->close();
