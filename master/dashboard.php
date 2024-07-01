<?php
include '../config.php';
include '../src/admin_topnav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DQ : ผู้ดูแลระบบ</title>

    <!-- Add Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .dashboard-container {
            max-width: 100%;
            margin: 0;
        }

        canvas {
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 100%;
            /* height: 90% !important; */
            margin: 50px 20px 50px 20px !important;
        }

        /* Card Container */
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Card Title */
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Card Content */
        .card-content {
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Card Button */
        .card-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card-button:hover {
            background-color: #0056b3;
        }

        span.c {
            font-weight: bold;
            font-size: 50px;
            margin: 60px;
            text-align: center;

        }

        .col-8 {
            padding-top: 20px;
        }

        .success{
            color: #54d613;
        }

        .warning{
            color: #ebf222;
        }
        
        .danger{
            color: #e82020;
        }

        .fs-18{
            font-size: 26px;
        }

       
    </style>
</head>

<body>
    <!-- ============================================== sidenav ===================================================== -->
    <div class="pt-4">

        <!-- ============================================== sidenav-menu ===================================================== -->
        <!-- <div style="width: 12%; height: 100%;" class="d-block" id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav fs-5">
                        <div class="sb-sidenav-menu-heading pt-3  mt-3">menu bar</div>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-simple ms-3 fs-4" style="color:#fff"></i></div>
                            แดชบอร์ด
                            <div class="sb-sidenav-collapse-arrow"></div>
                        </a>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="manage_user.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen ms-3 fs-4" style="color:#fff"></i></div>
                            ผูกตาราง
                            <div class="sb-sidenav-collapse-arrow"></div>
                        </a>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard ms-3 fs-4" style="color:#fff"></i></div>
                            ปัญหาจากผู้ใช้
                            <div class="sb-sidenav-collapse-arrow"></div>
                        </a>

                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
                            <div class="sb-nav-link-icon"><i class="fas fa-table ms-3 fs-4" style="color:#fff"></i>
                            </div>
                            ตาราง
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="table_users.php"><i class="fa fa-user fs-5 me-2"></i><span>ผู้ใช้</span></a>
                                <a class="nav-link" href="table_subject.php"><i class="fa-solid fa-layer-group fs-5 me-2"></i><span>วิชา</span></a>
                                <a class="nav-link" href="table_exam.php"><i class="fa-solid fa-scroll fs-5 me-2"></i><span>ข้อสอบ</span></a>
                            </nav>
                        </div>

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
                                    window.location.href = "../back-end/logout_admin.php";
                                }
                            });
                        }
                    </script>
                </div>

            </nav>
        </div> -->

        <!-- ============================================== sidenav-content ===================================================== -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <br><br>
                    <div class="row">
                        <div class="dashboard-container">
                            <!-- <h1>Dashboard</h1> -->
                            <br><br><br>
                            <div class="row d-flex justify-content-center mt-5 mb-5">
                                <!-- Cards -->
                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT user_id) as userCount FROM tb_user";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $userCount = $row['userCount'];
                                } else {
                                    $userCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="icon d-flex justify-content-between">
                                                    <img width="100px" height="100px"src="../src/img/user-svgrepo-com.svg" alt="User">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <span class="c d-flex justify-content-center"><?php echo $userCount; ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                            <span class="d-flex fs-18">จำนวนผู้ใช้</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT SubjectID) as subjectCount FROM tb_subject";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $subjectCount = $row['subjectCount'];
                                } else {
                                    $subjectCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="icon">
                                                    <img width="100px" height="100px"
                                                        src="../src/img/book-2-svgrepo-com.svg" alt="Subject">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <span class="c d-flex justify-content-center"><?php echo $subjectCount; ?></span>
                                            </div>
                                            <div class="col-3 mt-4">
                                               
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="d-flex fs-18">จำนวนวิชา</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT id_exam) as examCount FROM tb_exam";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $examCount = $row['examCount'];
                                } else {
                                    $examCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="icon">
                                                    <img width="100px" height="100px"
                                                        src="../src/img/archive-svgrepo-com.svg" alt="Exam">
                                                </div>
                                            </div>
                                            <div class="col-5 mt-3">
                                                <span class="c d-flex justify-content-center"><?php echo $examCount; ?></span>
                                            </div>
                                            <div class="col-3 mt-4 ">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="d-flex fs-18">จำนวนวิชาที่ลงทะเบียน</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-5">
                                <!-- Cards -->
                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT id_exam) as examCount FROM tb_exam WHERE status = 'ยังไม่อัปโหลดไฟล์'";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $examCount = $row['examCount'];
                                } else {
                                    $examCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="icon">
                                                    <img width="100px" height="100px"
                                                        src="../src/img/archive-svgrepo-com.svg" alt="Exam">
                                                </div>
                                            </div>
                                            <div class="col-4 mt-3">
                                                <span class="c danger"><?php echo $examCount; ?></span>
                                            </div>
                                            <div class="col-4 mt-3">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <span class="d-flex danger fs-5">ยังไม่อัปโหลดไฟล์</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT id_exam) as examCount FROM tb_exam WHERE status = 'ยังไม่ประมวลผล'";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $examCount = $row['examCount'];
                                } else {
                                    $examCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="icon">
                                                    <img width="100px" height="100px"
                                                        src="../src/img/archive-svgrepo-com.svg" alt="Exam">
                                                </div>
                                            </div>
                                            <div class="col-4 mt-3">
                                                <span class="c warning"><?php echo $examCount; ?></span>
                                            </div>
                                            <div class="col-4 mt-3">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <span class="d-flex warning fs-5">ยังไม่ประมวลผล</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $sqlCount = "SELECT COUNT(DISTINCT id_exam) as examCount FROM tb_exam WHERE status = 'ประมวลผลเสร็จสิ้น'";
                                $resultCount = $conn->query($sqlCount);

                                if ($resultCount) {
                                    $row = $resultCount->fetch_assoc();
                                    $examCount = $row['examCount'];
                                } else {
                                    $examCount = 0;
                                }
                                ?>
                                <div class="col-3 ms-3 me-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-4 ">
                                                <div class="icon">
                                                    <img width="100px" height="100px"
                                                        src="../src/img/archive-svgrepo-com.svg" alt="Exam">
                                                </div>
                                            </div>
                                            <div class="col-4 mt-3">
                                                <span class="c success"><?php echo $examCount; ?></span>
                                            </div>
                                            <div class="col-4">
                                               
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                 <span class="d-flex fs-5 success mt-3">ประมวลผลเสร็จสิ้น</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
            </main>
        </div>
    </div>

    <!-- <script src="../src/js/script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>