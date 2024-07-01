<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
<?php
include "../config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $examid = mysqli_escape_string($conn, $_POST['examid']);
    $description = mysqli_escape_string($conn, $_POST['description']);
    $examname = mysqli_escape_string($conn, $_POST['examname']);
    $number = mysqli_escape_string($conn, $_POST['numberofverses']);
    $autodatetime = date("Y-m-d H:i:s");
    $user_id = $_SESSION['user_id']; // ค่า user_id จากการเข้าสู่ระบบ

    // Retrieve the maximum exam_runID for the given exam_id
    $maxRunIdSql = "SELECT MAX(exam_runID) AS max_run_id FROM tb_exam WHERE exam_id = '$examid'";
    $result = $conn->query($maxRunIdSql);
    $row = $result->fetch_assoc();
    $max_run_id = $row['max_run_id'];
    $status = 'ยังไม่อัปโหลดไฟล์';

    // If no previous entries for this exam, start exam_runID from 1
    if ($max_run_id === NULL) {
        $examrunid = 1;
    } else {
        // Otherwise, increment the max exam_runID by 1
        $examrunid = $max_run_id + 1;
    }

    // Check for duplicates
    $checkDuplicateSql = "SELECT exam_runID, exam_id FROM tb_exam WHERE exam_runID = '$examrunid' AND exam_id = '$examid' LIMIT 1";
    $result = $conn->query($checkDuplicateSql);

    if ($result->num_rows > 0) {
        // Handle duplicate entry
        echo "<script>
        Swal.fire({
            title: 'ข้อมูลซ้ำกับคีย์หลัก',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../home.php';
        });
     </script>";

        exit();
    } else {
        // Insert the new entry
        $insertSql = "INSERT INTO tb_exam (user_id, exam_runID, exam_description, exam_id, exam_name, numberofverses, status, autodatetime) VALUES ('$user_id', '$examrunid', '$description', '$examid', '$examname', '$number', '$status', '$autodatetime')";

        if ($conn->query($insertSql) === TRUE) {
            // Handle successful insertion
            echo "<script>
                    Swal.fire({
                        title: 'สร้างไอดีการประมวลผลรายวิชาสำเร็จ',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = '../home.php';
                    });
                  </script>";
        } else {
            // Handle insertion error
            echo "<script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    }
}
?>
