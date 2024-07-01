<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
<?php
session_start();
include('../config.php');
$errors = array();

if (isset($_POST['reg_user'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['userid']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $prefix = mysqli_real_escape_string($conn, $_POST['prefix']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $re_dt = date("Y-m-d H:i:s");

    // Check if the username already exists in the database
    $existingUserQuery = "SELECT * FROM tb_user WHERE user_username = '$email'";
    $query = mysqli_query($conn, $existingUserQuery);
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        if ($result['user_username'] === $email) {
            array_push($errors, "มีผู้ใช้นี้อยู่ในระบบแล้ว");
            echo "<script>
                Swal.fire({
                    title: 'มีผู้ใช้นี้อยู่ในระบบแล้ว',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../login.php';
                });
              </script>";
        }
    }

    if (count($errors) == 0) {
        $passwordenc = md5($password);
        // Insert the user data into the database
        $sql = "INSERT INTO tb_user (user_id, user_username, user_password, user_prefix ,user_firstname, user_lastname, user_level, regis_datetime) VALUES ('$userid','$email', '$passwordenc', '$prefix' ,'$firstname', '$lastname','member','$re_dt')";
        mysqli_query($conn, $sql);
        $_SESSION['user_username'] = $email;
        $_SESSION['user_firstname'] = $firstname;
        $_SESSION['success'] = "You are now logged in";

        echo "<script>
                Swal.fire({
                    title: 'ลงทะเบียนสำเร็จ',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = '../master/table_users.php';
                });
              </script>";

        exit();
    }
} else {
    array_push($errors, "เกิดข้อผิดพลาดในการลงทะเบียน");
    echo "<script>
            Swal.fire({
                title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
                text: '" . implode("\n", $errors) . "',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = '../master/table_users.php';
            });
          </script>";
    exit();
}
