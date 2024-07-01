<?php
include "config.php";
include "src/topnav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงรายงาน</title>

    <style>
        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* Modal Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .text {
            color: #6e6e6e;
        }

        .text:focus {
            background-color: rgba(0, 0, 0, 0.05);
            border: 1px solid #c2c2c2;
            color: #6e6e6e;
            outline: none;
        }

        .tabs {
            width: fit-content !important;
            border-top: ridge;
            border-left: ridge;
            padding: 0;
        }

        .tabs>button {
            background-color: #DCDCDC !important;
            border: none !important;
        }

        .tabs>button:focus {
            background-color: #fff !important;
            border: inset !important;
        }

        .tab-content {
            display: none;
        }

        .active-tab {
            display: block;
        }

        .tab-content.card-body {
            height: fit-content;
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
                            <div class="sb-nav-link-icon"><i class="fas fa-circle-info ms-3 fs-4"
                                    style="color:#fff"></i>
                            </div>
                            แนะนำการใช้งาน
                        </a> -->

                    </div>
                </div>
                <div style="height: 80px;" class="sb-sidenav-footer">
                    <a style="padding: 10px 16px 16px 16px;" class="nav-link d-flex flex-row fs-5" href="#"
                        onclick="logout()">
                        <div class="d-flex flex-column justify-content-center"><i
                                class="fas fa-sign-out ms-3 fs-4 me-3"></i></div>
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
                    <div class="row">
                        <!-- ============================================== exam id ===================================================== -->
                        <h1 class="mt-3 pt-3">Report</h1>
                        <ol class="breadcrumb mb-4 ms-3">
                            <li class="breadcrumb-item active fs-18">แสดงรายงาน</li>
                        </ol>
                        <div style="background-color: #1F2336;" class="card mb-4 ">
                            <?php
                            if (isset($_GET['id_exam'])) {
                                $id_exam = $_GET['id_exam'];

                                // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
                                $examsql = "SELECT user_id, exam_id, exam_name, numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
                                $examresult = $conn->query($examsql);

                                // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
                                if ($examresult->num_rows > 0) {
                                    // ดึงข้อมูลจากแถวแรกเนื่องจาก numberofverses เป็นข้อมูลเดียว
                                    $row = $examresult->fetch_assoc();
                                    $user_id = $row["user_id"];
                                    $exam_id = $row["exam_id"];
                                    $exam_name = $row["exam_name"];
                                    $numberofverses = $row["numberofverses"];

                                    // คำนวณจำนวนคอลัมน์ที่ต้องแสดงในตาราง item
                                    $numColumns = intval($numberofverses);
                                    ?>
                                    <form style="background-color: #1F2336;"
                                        class=" d-flex flex-row justify-content-center gap-5" action="" method="POST"
                                        enctype="multipart/form-data" onsubmit="return validateForm()">
                                        <input class="text fs-18" type="text" name="exam_id" id="exam_id"
                                            value="รหัสวิชา: <?php echo $exam_id; ?>" readonly required>
                                        <input class="text fs-18" type="text" name="exam_name" id="exam_name"
                                            value="ชื่อวิชา: <?php echo $exam_name; ?>" readonly required>
                                        <input class="text fs-18" type="text" name="numberofverses" id="numberofverses"
                                            value="จำนวนข้อ: <?php echo $numberofverses; ?>" readonly required>

                                    </form>
                                    <?php
                                } else {
                                    echo "ไม่พบข้อมูลที่ค้นหา";
                                }
                            } else {
                                echo "ไม่ได้รับค่า id";
                            }
                            ?>
                        </div>

                        <!-- ============================================== Tabs for each table ============================================== -->
                        <div class="tabs d-flex justify-content-center ms-3 mb-4">
                            <button class="fs-18" onclick="showTab('tab1')">รายงานคุณภาพทั้งฉบับ |</button>
                            <button class="fs-18" onclick="showTab('tab2')">รายงานคุณภาพรายข้อ |</button>
                            <button class="fs-18" onclick="showTab('tab3')">รายงานข้อสอบที่ตรวจแล้ว |</button>
                            <button class="fs-18" onclick="showTab('tab4')">รายงานจำนวนการตอบถูกในแต่ละข้อ |</button>
                            <button class="fs-18" onclick="showTab('allTabs')">แสดงรายงานทั้งหมด</button>
                        </div>

                        <!-- ============================================== ตารารงแสดงคุณภาพทั้งฉบับ ===================================================== -->
                        <div id="tab1" class="tab-content">
                            <div class="card bg-white mb-4 mt-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานคุณภาพทั้งฉบับ
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];
                                                $reliabilitySql = "SELECT * FROM result_reliability WHERE id_exam = '$id_exam'";
                                                $reliabilityQuery = mysqli_query($conn, $reliabilitySql);
                                                $tb = mysqli_fetch_array($reliabilityQuery, MYSQLI_ASSOC);

                                                ?>
                                                <br>
                                                <table id="datatablesSimple" class="datatable-table">
                                                    <thead style="background-color: #1F2336; color:#fff;">
                                                        <tr>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">ค่าความเชื่อมั่น</a></th>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">เปอร์เซ็นความเชื่อมั่น</a></th>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">แปลผลความเชื่อมั่น</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $tb["reliability"]; ?></td>
                                                            <td><?php echo $tb["percen_reliability"]; ?></td>
                                                            <td><?php echo $tb["rel_reliability"]; ?></td>
                                                        </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== ตารางแสดงคุณภาพรายข้อ ===================================================== -->
                        <div id="tab2" class="tab-content">
                            <div class="card bg-white mb-4 mt-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานคุณภาพรายข้อ
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];
                                                $search = isset($_GET['search']) ? $_GET['search'] : '';

                                                $sql = "SELECT * FROM tb_answer WHERE id_exam = '$id_exam' AND (ans_item LIKE '%$search%' OR det_p_meaning LIKE '%$search%' OR det_r_meaning LIKE '%$search%')";
                                                $result = $conn->query($sql);

                                                // Check if there are rows in the result set
                                                if ($result->num_rows > 0) {
                                                    ?>
                                                    <div class="ms-5 mb-2 d-flex justify-content-end">
                                                        <input style="width:200px" id="searchInput" name="search"
                                                            class="datatable-input" placeholder="Search..." type="search"
                                                            title="Search within table" aria-controls="datatablesSimple"
                                                            value="<?php echo htmlspecialchars($search); ?>">
                                                        <input type="hidden" name="id_exam"
                                                            value="<?php echo htmlspecialchars($id_exam); ?>">
                                                    </div>
                                                    <table id="datatablesSimple" class="datatable-table">
                                                        <thead style="background-color: #1F2336; color:#fff;">
                                                            <tr>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ข้อที่</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ค่าความยากง่าย</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">แปลผลความยากง่าย</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ค่าอำนาจจำแนก</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">แปลผลอำนาจจำแนก</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="searchResults">
                                                            <?php
                                                            // Loop through each row in the result set
                                                            while ($tb = $result->fetch_assoc()) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo htmlspecialchars($tb["ans_item"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($tb["det_difficulty"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($tb["det_p_meaning"]); ?></td>
                                                                    <td><?php echo htmlspecialchars($tb["det_discrimination"]); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($tb["det_r_meaning"]); ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                } else {
                                                    echo "No data found.";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('searchInput').addEventListener('input', function () {
                                var searchQuery = this.value.trim().toLowerCase();
                                var rows = document.querySelectorAll('#searchResults tr');

                                rows.forEach(function (row) {
                                    var text = row.textContent.toLowerCase();
                                    if (text.indexOf(searchQuery) === -1) {
                                        row.style.display = 'none';
                                    } else {
                                        row.style.display = '';
                                    }
                                });
                            });
                        </script>

                        <!-- ============================================== ตารารงแสดงผลการตรวจข้อสอบ ===================================================== -->
                        <div id="tab3" class="tab-content">
                            <div class="card bg-white mb-4 mt-4">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="fs-18">แสดงรายงานข้อสอบที่ตรวจแล้ว</div>
                                    <form action="back-end/export_excel.php" method="post">
                                        <input type="hidden" name="id_exam" value="<?php echo $id_exam; ?>">
                                        <input type="hidden" name="numberofverses" value="<?php echo $numberofverses; ?>">
                                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-file-export"></i> Export Excel</button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];

                                                // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
                                                $sql = "SELECT user_id, exam_id, exam_name, numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
                                                $result = $conn->query($sql);

                                                // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
                                                if ($result->num_rows > 0) {
                                                    // ดึงข้อมูลจากแถวแรกเนื่องจาก numberofverses เป็นข้อมูลเดียว
                                                    $row = $result->fetch_assoc();
                                                    $user_id = $row["user_id"];
                                                    $exam_id = $row["exam_id"];
                                                    $exam_name = $row["exam_name"];
                                                    $numberofverses = $row["numberofverses"];

                                                    // คำนวณจำนวนคอลัมน์ที่ต้องแสดงในตาราง item
                                                    $numColumns = intval($numberofverses);
                                                    ?>
                                                    <table id="datatablesSimple" class="datatable-table">
                                                        <thead style="background-color: #1F2336; color:#fff;">
                                                            <tr>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ชื่อไฟล์</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">รหัสนักศึกษา</a></th>
                                                                <?php
                                                                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                    echo "<th>ข้อ$colIndex</th>";
                                                                }
                                                                ?>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">คะแนนรวม</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT file_name, studentID,sumscore";
                                                            for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                $sql .= ", item$colIndex";
                                                            }
                                                            $sql .= " FROM tb_correct_answer WHERE id_exam = '$id_exam'";

                                                            $result = $conn->query($sql);

                                                            if ($result) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $row['file_name'] . "</td>";
                                                                    echo "<td>" . $row['studentID'] . "</td>";
                                                                    for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                        echo "<td>" . $row["item$colIndex"] . "</td>";
                                                                    }
                                                                    echo "<td>" . $row['sumscore'] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            } else {
                                                                echo "Error: " . $conn->error;
                                                            }
                                                            ?>
                                                    </table>
                                                    <?php
                                                } else {
                                                    echo "ไม่พบข้อมูลที่ค้นหา";
                                                }
                                            } else {
                                                echo "ไม่ได้รับค่า id";
                                            }
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== ตารางแสดงจำนวนการตอบถูกในแต่ละข้อ ===================================================== -->
                        <div id="tab4" class="tab-content">
                            <div class="card bg-white mb-4 mt-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานจำนวนการตอบถูกในแต่ละข้อ (คน)
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            $sql = "SELECT * FROM item_counts WHERE id_exam = '$id_exam'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                ?>
                                                <table id="datatablesSimple" class="datatable-table">
                                                    <thead style="background-color: #1F2336; color:#fff;">
                                                        <tr>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">จำนวนผู้สอบ</a></th>
                                                            <?php
                                                            for ($i = 1; $i <= $numberofverses; $i++) {
                                                                echo "<th>ข้อ$i</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                <td> <?php echo $row["total_std"]; ?> </td>
                                                                <?php
                                                                for ($i = 1; $i <= $numberofverses; $i++) {
                                                                    echo "<td>" . $row["item$i"] . "</td>";
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                        <?php
                                                        }
                                                        echo "</table>";
                                            } else {
                                                echo "0 results";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white">
                                <div class="card-body">
                                    <div class="datatable-container">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                    <?php
                                    $sql = "SELECT * FROM item_counts WHERE id_exam = '$id_exam' AND numberofverses = '$numberofverses'";
                                    $result = $conn->query($sql);

                                    $data = [];

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            for ($i = 1; $i <= $numberofverses; $i++) {
                                                $data[] = $row["item$i"];
                                            }
                                        }
                                    }
                                    ?>

                                    <script>
                                        var ctx = document.getElementById('myChart').getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [
                                                    <?php
                                                    for ($i = 1; $i <= $numberofverses; $i++) {
                                                        echo "'ข้อ$i', ";
                                                    }
                                                    ?>
                                                ],
                                                datasets: [{
                                                    label: 'จำนวนผู้สอบที่ตอบถูก (คน)',
                                                    data: <?php echo json_encode($data); ?>,
                                                    backgroundColor: 'rgba(54, 162, 235, 0.2)', 
                                                    borderColor: 'rgba(54, 162, 235, 1)', 
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== แสดงทั้งหมด ===================================================== -->
                        <div id="allTabs" class="tab-content">
                            <!-- ============================================== ตารารงแสดงคุณภาพทั้งฉบับ ===================================================== -->
                            <div class="card bg-white mb-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานคุณภาพทั้งฉบับ
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];
                                                $reliabilitySql = "SELECT * FROM result_reliability WHERE id_exam = '$id_exam'";
                                                $reliabilityQuery = mysqli_query($conn, $reliabilitySql);
                                                $tb = mysqli_fetch_array($reliabilityQuery, MYSQLI_ASSOC);

                                                ?>
                                                <br>
                                                <table id="datatablesSimple" class="datatable-table">
                                                    <thead style="background-color: #1F2336; color:#fff;">
                                                        <tr>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">ค่าความเชื่อมั่น</a></th>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">เปอร์เซ็นความเชื่อมั่น</a></th>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">แปลผลความเชื่อมั่น</a></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo $tb["reliability"]; ?></td>
                                                            <td><?php echo $tb["percen_reliability"]; ?></td>
                                                            <td><?php echo $tb["rel_reliability"]; ?></td>
                                                        </tr>
                                                </table>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================== ตารางแสดงคุณภาพรายข้อ ===================================================== -->
                            <div class="card bg-white mb-4">
                                <div class="card-header">
                                    ตารางแสดงคุณภาพรายข้อ
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];
                                                $pSql = "SELECT * FROM tb_answer WHERE id_exam = '$id_exam'";
                                                $pQuery = mysqli_query($conn, $pSql);

                                                // Check if there are rows in the result set
                                                if (mysqli_num_rows($pQuery) > 0) {
                                                    ?>
                                                    <br>
                                                    <table id="datatablesSimple" class="datatable-table">
                                                        <thead style="background-color: #1F2336; color:#fff;">
                                                            <tr>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ข้อที่</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ค่าความยากง่าย</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">แปลผลความยากง่าย</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ค่าอำนาจจำแนก</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">แปลผลอำนาจจำแนก</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Loop through each row in the result set
                                                            while ($tb = mysqli_fetch_array($pQuery, MYSQLI_ASSOC)) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $tb["ans_item"]; ?></td>
                                                                    <td><?php echo $tb["det_difficulty"]; ?></td>
                                                                    <td><?php echo $tb["det_p_meaning"]; ?></td>
                                                                    <td><?php echo $tb["det_discrimination"]; ?></td>
                                                                    <td><?php echo $tb["det_r_meaning"]; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                } else {
                                                    echo "No data found.";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============================================== ตารางแสดงจำนวนการตอบถูกในแต่ละข้อ ===================================================== -->
                            <div class="card bg-white mb-4 mt-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานจำนวนการตอบถูกในแต่ละข้อ (คน)
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            $sql = "SELECT * FROM item_counts WHERE id_exam = '$id_exam'";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                ?>
                                                <table id="datatablesSimple" class="datatable-table">
                                                    <thead style="background-color: #1F2336; color:#fff;">
                                                        <tr>
                                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                                    class="datatable-sorter">จำนวนผู้สอบ</a></th>
                                                            <?php
                                                            for ($i = 1; $i <= $numberofverses; $i++) {
                                                                echo "<th>ข้อ$i</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Output data of each row
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <tr>
                                                                <td> <?php echo $row["total_std"]; ?> </td>
                                                                <?php
                                                                for ($i = 1; $i <= $numberofverses; $i++) {
                                                                    echo "<td>" . $row["item$i"] . "</td>";
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                        <?php
                                                        }
                                                        echo "</table>";
                                            } else {
                                                echo "0 results";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================== ตารางแสดงผลการตรวจข้อสอบ ===================================================== -->
                            <div class="card bg-white mb-4">
                                <div class="card-header fs-18">
                                    แสดงรายงานข้อสอบที่ตรวจแล้ว
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <div class="datatable-container">
                                            <?php
                                            if (isset($_GET['id_exam'])) {
                                                $id_exam = $_GET['id_exam'];

                                                // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
                                                $sql = "SELECT user_id, exam_id, exam_name, numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
                                                $result = $conn->query($sql);

                                                // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
                                                if ($result->num_rows > 0) {
                                                    // ดึงข้อมูลจากแถวแรกเนื่องจาก numberofverses เป็นข้อมูลเดียว
                                                    $row = $result->fetch_assoc();
                                                    $user_id = $row["user_id"];
                                                    $exam_id = $row["exam_id"];
                                                    $exam_name = $row["exam_name"];
                                                    $numberofverses = $row["numberofverses"];

                                                    // คำนวณจำนวนคอลัมน์ที่ต้องแสดงในตาราง item
                                                    $numColumns = intval($numberofverses);
                                                    ?>
                                                    <table id="datatablesSimple" class="datatable-table">
                                                        <thead style="background-color: #1F2336; color:#fff;">
                                                            <tr>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">ชื่อไฟล์</a></th>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">รหัสนักศึกษา</a></th>
                                                                <?php
                                                                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                    echo "<th>ข้อ$colIndex</th>";
                                                                }
                                                                ?>
                                                                <th data-sortable="true" style="width: auto;"><a href="#"
                                                                        class="datatable-sorter">คะแนนรวม</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT file_name, studentID,sumscore";
                                                            for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                $sql .= ", item$colIndex";
                                                            }
                                                            $sql .= " FROM tb_correct_answer WHERE id_exam = '$id_exam'";

                                                            $result = $conn->query($sql);

                                                            if ($result) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<tr>";
                                                                    echo "<td>" . $row['file_name'] . "</td>";
                                                                    echo "<td>" . $row['studentID'] . "</td>";
                                                                    for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                                                                        echo "<td>" . $row["item$colIndex"] . "</td>";
                                                                    }
                                                                    echo "<td>" . $row['sumscore'] . "</td>";
                                                                    echo "</tr>";
                                                                }
                                                            } else {
                                                                echo "Error: " . $conn->error;
                                                            }
                                                            ?>
                                                    </table>

                                                    <?php

                                                } else {
                                                    echo "ไม่พบข้อมูลที่ค้นหา";
                                                }
                                            } else {
                                                echo "ไม่ได้รับค่า id";
                                            }
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal Content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="reportForm" action="export_excel.php" method="post">
            <label for="creator">Creator Name:</label>
            <input type="text" id="creator" name="creator" required><br><br>

            <label for="lastModifiedBy">Last Modified By:</label>
            <input type="text" id="lastModifiedBy" name="lastModifiedBy" required><br><br>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required><br><br>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required><br><br>

            <label for="keywords">Keywords:</label>
            <input type="text" id="keywords" name="keywords" required><br><br>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required><br><br>

            <button type="submit">Generate Report</button>
        </form>
    </div>

</div>
    <script>
        function showTab(tabId) {
            var tabs = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = "none";
            }
            document.getElementById(tabId).style.display = "block";
        }
        window.onload = function () {
            showTab('allTabs');
        };
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function () {
            modal.style.display = "block";
        }
        span.onclick = function () {
            modal.style.display = "none";
        }
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>