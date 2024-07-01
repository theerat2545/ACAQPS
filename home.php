<?php
include "config.php";
include "src/topnav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/css/sidenav.css" rel="stylesheet">
    <title>หน้าหลัก</title>

    <style>
        #searchField {
            width: 170px !important;
        }

        #searchInput {
            margin: 8px;
        }

        td {
            font-size: 18px;
        }

        th {
            font-size: 18px;
        }

        .fs-18 {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <!-- ============================================== sidenav ===================================================== -->
    <div class="d-flex" id="layoutSidenav">

        <!-- ============================================== sidenav-menu ===================================================== -->
        <div style="width: 12%; height: 100%;" class="d-block" id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav fs-5">
                        <div class="sb-sidenav-menu-heading pt-3  mt-3">menu bar</div>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-home ms-3 fs-4" style="color:#fff"></i></div>
                            หน้าหลัก
                        </a>

                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="report.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area ms-3 fs-4" style="color:#fff"></i>
                            </div>
                            รายงานผล
                        </a>

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
                    <br>
                    <div class="row">

                        <!-- ============================================== form create id exam ===================================================== -->
                        <div class="form-container mb-4">
                            <h1 class="">Home</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active fs-18">หน้าหลัก</li>
                            </ol>
                            <div class="d-flex justify-content-center">
                                <form onsubmit="return validateForm()" class="form" action="back-end/regis_exam_db.php" method="post">
                                    <span class="fw-bold fs-6 text-dark">
                                        <p> </p><br>
                                        <h4>ลงทะเบียนวิชา</h4>
                                    </span><br>
                                    <label for="examid" class="label ms-4">
                                        <select name="examid" id="examid" required>
                                            <option value="">--โปรดเลือก--</option>
                                            <?php
                                            if (isset($_SESSION['user_id'])) {
                                                // กำหนดค่า $user_id จาก session
                                                $userid = $_SESSION['user_id'];
                                                // คำสั่ง SQL เลือกวิชาที่ผู้ใช้คนนั้นสอน
                                                $sql = "SELECT subjectID, subjectName FROM tb_userandsubject WHERE user_id = '$userid'";
                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $subjectID = $row['subjectID'];
                                                        $subjectName = $row['subjectName'];
                                                        echo "<option value=\"$subjectID\">$subjectID - $subjectName</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </label>

                                    <label for="" class="label ms-4">
                                        <input class="text" type="text" name="examname" id="examname"
                                            placeholder="ชื่อวิชา" readonly required>
                                    </label>
                                    <label for="" class="label ms-4">
                                        <input class="text" type="text" name="description" id="description"
                                            placeholder="รายละเอียด">
                                    </label>
                                    <label for="" class="label ms-4">
                                        <abbr class=" me-2" title="กรุณาใส่จำนวนข้อสอบให้ตรงกับชุดข้อสอบจริงไม่ฉะนั้นจะทำให้ค่าออกมาคลาดเคลื่อน"><i class="fa-solid fa-circle-info"></i></abbr>
                                        <input class="text" type="text" name="numberofverses" id="numberofverses" placeholder="จำนวนข้อ" required>
                                    </label>
                                    <button class="btn btn-primary text-light ms-4" type="submit" value="Submit"><i
                                            class="fa-solid fa-plus"></i> เพิ่ม</button>
                                    <p> </p><br>

                                </form><br><br>
                            </div>
                        </div>

                        <!-- ============================================== table exam ===================================================== -->
                        <div class="card bg-white mb-4">
                            <div class="card-body">
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="row pb-3">
                                        <?php
                                        // รับค่า statusText จาก query string
                                        $statusText = isset($_GET['statusText']) ? $_GET['statusText'] : 'all';
                                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                                        $searchField = isset($_GET['searchField']) ? $_GET['searchField'] : 'all'; // เพิ่มตัวแปร searchField
                                        
                                        $sql = "SELECT * FROM tb_exam WHERE user_id = '$user_id'";

                                        // เพิ่มเงื่อนไขการค้นหา statusText ถ้าไม่ใช่ 'all'
                                        if ($statusText != 'all') {
                                            $sql .= " AND status = '$statusText'";
                                        }

                                        // เพิ่มเงื่อนไขการค้นหาข้อความทั้งหมดที่คุณต้องการค้นหา
                                        if ($search !== '' && $searchField !== 'all') { // เพิ่มเงื่อนไขให้ค้นหาเฉพาะเมื่อไม่เลือก "ทั้งหมด"
                                            $sql .= " AND $searchField LIKE '%$search%'";
                                        }

                                        $result = $conn->query($sql);
                                        $total_records = $result->num_rows;

                                        $records_per_page = 5;
                                        $total_pages = ceil($total_records / $records_per_page);

                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;
                                        $sql .= " LIMIT $offset, $records_per_page";
                                        $result = $conn->query($sql);
                                        ?>

                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            <form style="display:block; margin-block-end: 0 !important;" action=""
                                                method="GET">
                                                <div class="ms-5 d-flex justify-content-end">                                     
                                                    <select id="searchField" name="searchField" class="form-select">
                                                        <option value="all" <?php if ($searchField === 'all')
                                                            echo 'selected'; ?>>ทั้งหมด</option>
                                                        <option value="id_exam" <?php if ($searchField === 'id_exam')
                                                            echo 'selected'; ?>>ไอดี</option>
                                                        <option value="exam_runID" <?php if ($searchField === 'exam_runID')
                                                            echo 'selected'; ?>>ครั้งที่</option>
                                                        <option value="exam_description" <?php if ($searchField === 'exam_description')
                                                            echo 'selected'; ?>>รายละเอียด</option>
                                                        <option value="exam_id" <?php if ($searchField === 'exam_id')
                                                            echo 'selected'; ?>>รหัสวิชา</option>
                                                        <option value="exam_name" <?php if ($searchField === 'exam_name')
                                                            echo 'selected'; ?>>ชื่อวิชา</option>
                                                        <option value="numberofverses" <?php if ($searchField === 'numberofverses')
                                                            echo 'selected'; ?>>
                                                            จำนวนข้อ</option>
                                                        <option value="autodatetime" <?php if ($searchField === 'autodatetime')
                                                            echo 'selected'; ?>>
                                                            วันที่และเวลา</option>
                                                        <option value="status" <?php if ($searchField === 'status')
                                                            echo 'selected'; ?>>สถานะ</option>
                                                    </select>

                                                    <input id="searchInput" style="width:200px" name="search"
                                                        class="datatable-input" placeholder="Search..." type="search"
                                                        title="Search within table" aria-controls="datatablesSimple"
                                                        value="<?php echo $search; ?>">
                                                    <button style="margin:auto 0 auto 0" type="submit"
                                                        class="btn btn-primary"><i
                                                            class="fa-solid fa-magnifying-glass"></i></button>
                                                    <button style="margin:auto 0 auto 10px" type="button"
                                                        class="btn btn-secondary" onclick="resetSearch()"><i
                                                            class="fa-solid fa-repeat"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="datatable-container">
                                        <table id="datatablesSimple" class="datatable-table">
                                            <thead style="background-color: #1F2336; color:#fff;">
                                                <tr>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">ไอดี</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">ครั้งที่</a></th>
                                                    <th data-sortable="true" style="width: 300px;"><a href="#"
                                                            class="datatable-sorter">รายละเอียด</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">รหัสวิชา</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">ชื่อวิชา</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">จำนวนข้อ</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">วันที่และเวลา</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">สถานะ</a></th>

                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">อัปโหลดไฟล์และประมวลผล</a></th>
                                                    <th data-sortable="true" style="width: auto;"><a href="#"
                                                            class="datatable-sorter">ลบ</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($tb_exam = $result->fetch_assoc()) {
                                                        // ตรวจสอบว่าผู้ใช้เป็นเจ้าของตารางหรือไม่
                                                        if ($tb_exam['user_id'] == $_SESSION['user_id']) {
                                                            // กำหนดสถานะตามเงื่อนไขของคุณ
                                                            $statusClass = '';
                                                            $statusText = '';
                                                            $statusColor = '';
                                                            $disableImportButton = false;

                                                            if ($tb_exam['status'] == 'ประมวลผลเสร็จสิ้น') {
                                                                $statusClass = 'text-success';
                                                                $statusText = 'ประมวลผลเสร็จสิ้น';
                                                                $statusColor = 'bg-success';
                                                                $disableImportButton = true;
                                                            } elseif ($tb_exam['status'] == 'ยังไม่ประมวลผล') {
                                                                $statusClass = 'text-warning';
                                                                $statusText = 'ยังไม่ประมวลผล';
                                                                $statusColor = 'bg-warning';
                                                            } elseif ($tb_exam['status'] == 'ยังไม่อัปโหลดไฟล์') {
                                                                $statusClass = 'text-danger';
                                                                $statusText = 'ยังไม่อัปโหลดไฟล์';
                                                                $statusColor = 'bg-danger';
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $tb_exam["id_exam"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["exam_runID"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["exam_description"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["exam_id"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["exam_name"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["numberofverses"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["autodatetime"]; ?>
                                                                </td>

                                                                <td>
                                                                    <span class="badge fs-18 <?php echo $statusColor; ?>">
                                                                        <?php echo $statusText; ?>
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <a class="btn btn-secondary fs-18 <?php echo $disableImportButton ? 'disabled' : ''; ?>"
                                                                        <?php echo $disableImportButton ? 'disabled' : ''; ?>
                                                                        href="up_excel.php?id_exam=<?php echo $tb_exam["id_exam"]; ?>">
                                                                        <i class="fa-solid fa-plus"></i> เพิ่มและประมวลผล
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-danger text-light fs-18"
                                                                        onclick="confirmDelete(<?php echo $tb_exam['id_exam']; ?>)">
                                                                        <i class="fa-solid fa-eraser"></i> ลบ
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="datatable-bottom d-flex justify-content-end">
                                        <div class="datatable-bottom">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <?php
                                                    if ($total_pages > 1) {
                                                        // Previous Page Link
                                                        echo "<li class='page-item " . ($page == 1 ? 'disabled' : '') . "'>";
                                                        echo "<a class='page-link' href='?page=" . ($page - 1) . "' aria-label='Previous'>";
                                                        echo "<span aria-hidden='true'>&laquo;</span>";
                                                        echo "</a></li>";

                                                        // Page Links
                                                        for ($i = 1; $i <= $total_pages; $i++) {
                                                            echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'>";
                                                            echo "<a class='page-link' href='?page=$i'>$i</a>";
                                                            echo "</li>";
                                                        }

                                                        // Next Page Link
                                                        echo "<li class='page-item " . ($page == $total_pages ? 'disabled' : '') . "'>";
                                                        echo "<a class='page-link' href='?page=" . ($page + 1) . "' aria-label='Next'>";
                                                        echo "<span aria-hidden='true'>&raquo;</span>";
                                                        echo "</a></li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </nav>
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

    <script>
        // รับค่าเมื่อมีการเลือกในเมนูดรอปดาวน์ examid
        document.getElementById("examid").addEventListener("change", function () {
            // ดึงค่าที่ถูกเลือกในเมนูดรอปดาวน์
            var selectedOption = this.options[this.selectedIndex];

            // ดึงรหัสวิชาและชื่อวิชา
            var subjectID = selectedOption.value;
            var subjectName = selectedOption.textContent.split(" - ")[1];

            // กำหนดค่าให้กับช่อง examname
            document.getElementById("examname").value = subjectName;
        });
        function confirmDelete(examId) {
            Swal.fire({
                title: 'ต้องการลบข้อมูลหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './back-end/delete_exam_db.php?id_exam=' + examId;
                }
            });
        }
        var searchField = document.getElementById('searchField');
        var searchInput = document.getElementById('searchInput');
        var typingTimer;
        var doneTypingInterval = 500; // milliseconds

        searchField.addEventListener('change', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        function doneTyping() {
            var searchQuery = searchInput.value.trim();
            var searchFieldVal = searchField.value;
            var statusTextVal = '<?php echo $statusText; ?>'; // เก็บค่า statusText จาก PHP

            var urlParams = new URLSearchParams(window.location.search);

            urlParams.set('search', searchQuery);
            urlParams.set('searchField', searchFieldVal);
            urlParams.set('statusText', statusTextVal); // เพิ่มค่า statusText ใน query string

            window.history.replaceState({}, '', decodeURIComponent(`${window.location.pathname}?${urlParams}`));
        }

        function resetSearch() {
            document.getElementById('searchInput').value = '';
            var urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('search');
            window.history.replaceState({}, '', decodeURIComponent(`${window.location.pathname}?${urlParams}`));
            // เรียกฟังก์ชันเพื่อโหลดข้อมูลใหม่หลังจากรีเซ็ต
            location.reload();
        }
        function validateForm() {
            var input = document.getElementById("numberofverses").value;

            // ตรวจสอบว่าเป็นเลขหรือไม่
            if (isNaN(input)) {
                alert("กรุณากรอกเฉพาะตัวเลข");
                return false; // ไม่สามารถ submit ได้
            }

            // ตรวจสอบว่าเป็นเลขระหว่าง 10 ถึง 150 หรือไม่
            var number = parseInt(input);
            if (number < 10 || number > 150) {
                alert("กรุณากรอกเฉพาะเลขระหว่าง 10 ถึง 150");
                return false; 
            }
            return true; 
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>