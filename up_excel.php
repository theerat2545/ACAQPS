<?php
include "config.php";
include "src/topnav.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ตรวจสอบว่ามีไฟล์ถูกอัปโหลดหรือไม่
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // ตรวจสอบว่าไฟล์ถูกอัปโหลดสำเร็จหรือไม่
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            // ตรวจสอบประเภทของไฟล์
            if ($fileType === 'xlsx' || $fileType === 'xls') {
                $spreadsheet = IOFactory::load($file['tmp_name']);
                $worksheet = $spreadsheet->getActiveSheet();

                if (isset($_GET['id_exam'])) {
                    $id_exam = $_GET['id_exam'];

                    foreach ($worksheet->getRowIterator(2) as $row) {
                        $rowData = [];
                        foreach ($row->getCellIterator() as $cell) {
                            $rowData[] = $cell->getValue();
                        }

                        $file_name = $rowData[0];
                        $studentID = $rowData[1];

                        $sql = "INSERT INTO tb_examdetail (id_exam, file_name, studentID";
                        $values = "VALUES ('$id_exam', '$file_name', '$studentID'";

                        // สมมติว่ามีรายการทั้งหมด 80 รายการ (ปรับตามต้องการ)
                        for ($colIndex = 2; $colIndex <= 81; $colIndex++) {
                            $itemValue = isset($rowData[$colIndex]) ? $rowData[$colIndex] : '';
                            $sql .= ", item" . ($colIndex - 1);
                            $values .= ", '$itemValue'";
                        }

                        $sql .= ") " . $values . ")";
                        $conn->query($sql);

                        // ทำการอัปเดตคอลัมน์ status เป็น 1
                        $updateStatusQuery = "UPDATE tb_exam SET status = 'ยังไม่ประมวลผล' WHERE id_exam = '$id_exam'";
                        $conn->query($updateStatusQuery);
                    }

                    echo "<script>
                        Swal.fire({
                            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                            icon: 'success',
                            confirmButtonText: 'ตกลง'
                        }).then(function() {
                            // window.location.href = 'up_excel.php'; // ปรับ URL ที่ต้องการเปลี่ยนทางไป
                        });
                      </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'ไม่พบค่า id_exam',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        }).then(function() {
                            window.location.href = 'up_excel.php';
                        });
                      </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'รองรับเฉพาะไฟล์ .xlsx และ .xls เท่านั้น',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    }).then(function() {
                        // window.location.href = 'up_excel.php';
                    });
                  </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                }).then(function() {
                    window.location.href = 'up_excel.php';
                });
              </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัปโหลดและแสดงข้อมูลจากไฟล์ Excel</title>

    <style>
        .text {
            color: #6e6e6e;
        }

        .text:focus {
            background-color: rgba(0, 0, 0, 0.05);
            border: 1px solid #c2c2c2;
            color: #6e6e6e;
            outline: none;
        }

        td{
            font-size: 18px;
        }

        th{
            font-size: 18px;
        }

        .fs-18{
            font-size: 18px;
        }
    </style>

</head>

<body>
    <!-- ============================================== sidenav ===================================================== -->
    <div id="layoutSidenav">

        <!-- ============================================== sidenav-menu ===================================================== -->
        <div style="width: 12%; height: 100%;" class="d-block" id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav fs-5">
                        <div class="sb-sidenav-menu-heading pt-3  mt-3">Menu Bar</div>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="home.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home ms-3 fs-4" style="color:#fff"></i></div>
                            หน้าหลัก
                        </a>

                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="report.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area ms-3 fs-4" style="color:#fff"></i>
                            </div>
                            รายงานผล
                        </a>

                        <!-- <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="recommend.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-circle-info ms-3 fs-4" style="color:#fff"></i>
                            </div>
                            แนะนำการใช้งาน
                        </a> -->

                    </div>
                </div>
                <div style="height: 80px;" class="sb-sidenav-footer">
                    <a style="padding: 10px 16px 16px 16px;" class="nav-link d-flex flex-row fs-5" href="#" onclick="logout()">
                        <div class="d-flex flex-column justify-content-center"><i class="fas fa-sign-out ms-3 fs-4 me-3"></i></div>
                        ออกจากระบบ
                    </a>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script>
                        function logout() {
                            Swal.fire({
                                title: 'ยืนยันการออกจากระบบ',
                                text: 'คุณต้องการที่จะออกจากระบบหรือไม่?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'ใช่',
                                cancelButtonText: 'ไม่',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "back-end/logout_user.php";
                                }
                            });
                        }
                    </script>
                </div>

            </nav>
        </div>

        <!-- ============================================== sidenav-content ===================================================== -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br>
                    <div class="row">

                        <!-- ============================================== table exam ===================================================== -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="datatable-container">
                                        <?php
                                        if (isset($_GET['id_exam'])) {
                                            $id_exam = $_GET['id_exam'];

                                            // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
                                            $sql = "SELECT user_id, exam_id, exam_name, numberofverses, status FROM tb_exam WHERE id_exam = '$id_exam'";
                                            $result = $conn->query($sql);

                                            // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
                                            if ($result->num_rows > 0) {
                                                // ดึงข้อมูลจากแถวแรกเนื่องจาก numberofverses เป็นข้อมูลเดียว
                                                $row = $result->fetch_assoc();
                                                $user_id = $row["user_id"];
                                                $exam_id = $row["exam_id"];
                                                $exam_name = $row["exam_name"];
                                                $numberofverses = $row["numberofverses"];
                                                $status = $row["status"];

                                                // คำนวณจำนวนคอลัมน์ที่ต้องแสดงในตาราง item
                                                $numColumns = intval($numberofverses);
                                        ?>
                                                <form class="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                                                    <input class="text" type="text" name="user_id" id="user_id" value="ยูเซอร์ไอดี: <?php echo $user_id; ?>" readonly required>
                                                    <input class="text" type="text" name="id_exam" id="id_exam" value="ไอดี: <?php echo $id_exam; ?>" readonly required>
                                                    <input class="text" type="text" name="exam_id" id="exam_id" value="รหัสวิชา: <?php echo $exam_id; ?>" readonly required>
                                                    <input class="text" type="text" name="exam_name" id="exam_name" value="ชื่อวิชา: <?php echo $exam_name; ?>" readonly required>
                                                    <input class="text" type="text" name="numberofverses" id="numberofverses" value="จำนวนข้อ: <?php echo $numberofverses; ?>" readonly required>
                                                   
                                                    <?php
                                                    // Check if status is not equal to 1, then render the button
                                                    if ($row['status'] != 'ยังไม่ประมวลผล') {
                                                    ?>
                                                         <input class="btn btn-success ms-2" type="file" name="file" accept=".xlsx, .xls" id="fileInput" >
                                                        <button class="btn btn-warning text-light ms-2 fs-18" type="submit" name="submit">แสดงตาราง</button>
                                                        <!-- <a class="btn btn-primary ms-2" type="submit" href="javascript:void(0);">ตรวจหาคุณภาพ</a> -->
                                                    <?php
                                                    } else {
                                                        // Render a disabled button if status is equal to 1
                                                    ?>
                                                         <input class="btn btn-success ms-2" type="file" name="file" accept=".xlsx, .xls" id="fileInput" disabled>
                                                        <!-- <button class="btn btn-warning text-light ms-2" type="submit" name="submit" disabled>แสดงตาราง</button> -->
                                                        <a class="btn btn-primary ms-2 fs-18" type="submit" href="back-end/check_exam.php?id_exam=<?php echo $id_exam; ?>" >ตรวจหาคุณภาพ</a>
                                                    <?php
                                                    }
                                                    ?>
                                                    
                                                </form><br>
                                                <table id="datatablesSimple" class="datatable-table">
                                                    <thead style="background-color: #1F2336; color:#fff;">
                                                        <tr>
                                                            <th align="center" data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">ชื่อไฟล์</a></th>
                                                            <th align="center" style="width: auto;"><a href="#" class="datatable-sorter">รหัสนักศึกษา</a></th>
                                                            <?php
                                                            for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                echo "<th>ข้อ$colIndex</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT file_name, studentID";
                                                        for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                            $sql .= ", item$colIndex";
                                                        }
                                                        $sql .= " FROM tb_examdetail WHERE id_exam = '$id_exam'";

                                                        $result = $conn->query($sql);

                                                        if ($result) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $row['file_name'] . "</td>";
                                                                echo "<td>" . $row['studentID'] . "</td>";
                                                                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                    echo "<td>" . $row["item$colIndex"] . "</td>";
                                                                }
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "Error: " . $conn->error;
                                                        }
                                                        ?>
                                                </table>
                                        <?php
                                            } else {
                                                echo "<script>
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error',
                                                            text: 'ไม่พบข้อมูลที่ค้นหา',
                                                        }).then(function() {
                                                            window.location.href = 'home.php';
                                                        });
                                                 </script>";
                                            }
                                        } else {
                                            echo "<script>
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Error',
                                                            text: 'ไม่ได้รับค่า id',
                                                        }).then(function() {
                                                            window.location.href = 'home.php';
                                                        });
                                                 </script>";
                                        }
                                        ?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>-
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>