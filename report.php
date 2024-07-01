<?php
include "config.php";
include "src/topnav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางเช็ครายงานการประมวลผล</title>

    <style>
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
                    <br>
                    <div class="row">

                        <!-- ============================================== table exam ===================================================== -->
                        <div class="form-container mb-4">
                            <h1 class="">Report</h1>
                            <ol class="breadcrumb mb-4 ms-3">
                                <li class="breadcrumb-item active fs-18">รายงาน</li>
                            </ol>
                            <div class="card bg-white mb-5">
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <?php
                                        $searchField = isset($_GET['searchField']) ? $_GET['searchField'] : 'all';
                                        $searchValue = isset($_GET['search']) ? $_GET['search'] : '';

                                        $sql = "SELECT * FROM tb_exam WHERE user_id = '$user_id'";

                                        // Adjust the SQL query based on the selected search field
                                        if ($searchField !== 'all') {
                                            $sql .= " AND $searchField LIKE '%$searchValue%'";
                                        }

                                        $result = $conn->query($sql);
                                        $total_records = $result->num_rows;

                                        $records_per_page = 10;
                                        $total_pages = ceil($total_records / $records_per_page);

                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;

                                        $sql .= " LIMIT $offset, $records_per_page";
                                        $result = $conn->query($sql);
                                        ?>
                                        <!-- HTML Code for Search Form -->
                                        <div class="datatable-top">
                                            <div class="datatable-search d-flex flex-row gap-2">
                                                <form id="searchForm" style="display: flex ;" action="" method="GET">
                                                    <select id="searchField" name="searchField"
                                                        class="form-select me-1">
                                                        <option value="all" <?php if ($searchField === 'all')
                                                            echo 'selected'; ?>>ทั้งหมด</option>
                                                        <option value="id_exam" <?php if ($searchField === 'id_exam')
                                                            echo 'selected'; ?>>ไอดี</option>
                                                        <option value="exam_runID" <?php if ($searchField === 'exam_runID')
                                                            echo 'selected'; ?>>รหัสการประมวลผล</option>
                                                        <option value="exam_id" <?php if ($searchField === 'exam_id')
                                                            echo 'selected'; ?>>รหัสวิชา</option>
                                                        <option value="exam_name" <?php if ($searchField === 'exam_name')
                                                            echo 'selected'; ?>>ชื่อวิชา</option>
                                                        <option value="numberofverses" <?php if ($searchField === 'numberofverses')
                                                            echo 'selected'; ?>>
                                                            จำนวนข้อ</option>
                                                    </select>
                                                    <input style="margin: 8px 0 8px 8px;" id="searchInput" name="search"
                                                        class="datatable-input" placeholder="Search..." type="search"
                                                        title="Search within table" aria-controls="datatablesSimple"
                                                        value="<?php echo $searchValue ?>">
                                                    <button style="margin: 8px 8px 8px 0" type="submit"
                                                        class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                    <button style="margin: 8px 8px 8px 0" type="button"
                                                        onclick="resetSearch()" class="btn btn-secondary"><i class="fa-solid fa-repeat"></i></button>

                                                </form>
                                            </div>
                                        </div>

                                        <script>
                                            var searchForm = document.getElementById('searchForm');
                                            var searchInput = document.getElementById('searchInput');
                                            var searchField = document.getElementById('searchField');

                                            searchInput.addEventListener('input', function () {
                                                clearTimeout(typingTimer);
                                                typingTimer = setTimeout(doneTyping, 500); // Adjust the delay as needed
                                            });

                                            searchField.addEventListener('change', function () {
                                                doneTyping(); // Trigger search immediately when field selected
                                            });

                                            searchForm.addEventListener('submit', function (event) {
                                                event.preventDefault(); // Prevent the form from submitting
                                                doneTyping(); // Trigger search immediately when form submitted
                                            });

                                            function doneTyping() {
                                                var searchQuery = searchInput.value.trim();
                                                var selectedField = searchField.value;
                                                var urlParams = new URLSearchParams(window.location.search);
                                                urlParams.set('searchField', selectedField);
                                                urlParams.set('search', searchQuery);
                                                window.location.href = window.location.pathname + '?' + urlParams.toString();
                                            }
                                            function resetSearch() {
                                                searchInput.value = ''; // Clear the search input
                                                searchField.value = 'all'; // Set the search field to 'all'
                                                doneTyping(); // Trigger search
                                            }

                                        </script>

                                        <div class="datatable-container">
                                            <table id="datatablesSimple" class="datatable-table">
                                                <thead style="background-color: #1F2336; color:#fff;">
                                                    <tr>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">ไอดี</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">รหัสการประมวลผล</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">รหัสวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">ชื่อวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">จำนวนข้อ</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">วันที่และเวลา</a></th>

                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">ดูรายงาน</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        while ($tb_exam = $result->fetch_assoc()) {
                                                            // Determine the status based on your conditions
                                                            $status = $tb_exam['status'];
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $tb_exam["id_exam"]; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $tb_exam["exam_runID"]; ?>
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
                                                                    <?php
                                                                    // Check status and render button accordingly
                                                                    if ($status == 'ประมวลผลเสร็จสิ้น') {
                                                                        echo '<a class="btn btn-primary fs-18" href="show_report.php?id_exam=' . $tb_exam["id_exam"] . '"><i class="fa-solid fa-eye"></i> ดูรายงาน</a>';
                                                                    } else {
                                                                        // If status is 0 or 1, disable the button
                                                                        echo '<button class="btn btn-primary fs-18" disabled><i class="fa-solid fa-eye"></i> ดูรายงาน</button>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
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
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>