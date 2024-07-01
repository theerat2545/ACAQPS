<?php
include '../config.php';
include '../src/admin_topnav.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>DQ : ผู้ดูแลระบบ</title>

    <style>
         h6 {
            color: red;
        }
    </style>
</head>

<body>
    <!-- ============================================== sidenav ===================================================== -->
    <div class="pt-4">

        <!-- ============================================== sidenav-content ===================================================== -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <br><br>
                    <div class="row">
                        <div class="form-container">
                            <h1 class=""></h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item active"></li>
                            </ol>

                            <div class="card bg-white mb-4">
                                <div class="card-header">
                                    รายงานการประมวลผลข้อสอบ
                                </div>
                                <div class="card-body">
                                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <?php
                                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                                        $searchField = isset($_GET['searchField']) ? $_GET['searchField'] : 'all';
                                        $whereClause = '';

                                        if ($searchField !== 'all') {
                                            $whereClause = "$searchField LIKE '%$search%'";
                                        } else {
                                            $whereClause = "(user_id LIKE '%$search%' OR id_exam LIKE '%$search%' OR exam_name LIKE '%$search%' OR exam_runID LIKE '%$search%' OR exam_id LIKE '%$search%' OR numberofverses LIKE '%$search%')";
                                        }

                                        $sql = "SELECT * FROM tb_exam WHERE $whereClause";

                                        $result = $conn->query($sql);
                                        $total_records = $result->num_rows;

                                        $records_per_page = 10;
                                        $total_pages = ceil($total_records / $records_per_page);

                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;

                                        $sql = "SELECT * FROM tb_exam WHERE $whereClause LIMIT $offset, $records_per_page";
                                        $result = $conn->query($sql);
                                    ?>
                                        <div class="datatable-top">
                                            <div class="datatable-search d-flex gap-2">
                                            <form style="display:flex; margin-block-end: 0 !important" action="" method="get">
                                                <select name="searchField" class="form-select me-1">
                                                    <option value="all">ทั้งหมด</option>
                                                    <option value="user_id">ไอดีผู้ใช้</option>
                                                    <option value="id_exam">ไอดี</option>
                                                    <option value="exam_runID">การประมวลผลครั้งที่</option>
                                                    <option value="exam_id">รหัสวิชา</option>
                                                    <option value="exam_name">ชื่อวิชา</option>
                                                    <option value="numberofverses">จำนวนข้อ</option>
                                                    <option value="status">สถานะ</option>
                                                </select>
                                                <input style="margin: 8px 0 8px 8px;" name="search" class="datatable-input" placeholder="Search..." type="search" title="Search within table" aria-controls="datatablesSimple">
                                                <button style="margin: 8px 8px 8px 0" class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                                <button style="margin: 8px 8px 8px 0" class="btn btn-secondary" type="button" onclick="resetSearch()"><i class="fa-solid fa-repeat"></i></button>
                                            </form>
                                            <script>
                                                var searchField = document.querySelector('select[name="searchField"]');
                                                var searchInput = document.querySelector('input[name="search"]');
                                                var searchForm = document.querySelector('form');

                                                function resetSearch() {
                                                    var searchInput = document.querySelector('input[name="search"]');
                                                    var searchField = document.querySelector('select[name="searchField"]');
                                                    searchInput.value = ''; 
                                                    searchField.value = 'all'; 
                                                    searchForm.submit(); 
                                                }
                                            </script>
                                            </div>
                                        </div>
                                        <div class="datatable-container">
                                            <table id="datatablesSimple" class="datatable-table">
                                                <thead style="background-color: #1F2336; color:#fff;">
                                                    <tr>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">ไอดีผู้ใช้</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">ไอดี</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">การประมวลผลครั้งที่</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">รหัสวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">ชื่อวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">จำนวนข้อ</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">สถานะ</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">วันเวลาที่ลงทะเบียน</a></th>

                                                        <th data-sortable="true" style="width: auto;"><a href="#" class="datatable-sorter">ลบ</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
                                                    if ($result->num_rows > 0) {
                                                        // แสดงข้อมูลทีละแถว
                                                        while ($tb_exam = $result->fetch_assoc()) {
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

                                                            echo "<tr>";
                                                            echo "<td><h6>" . $tb_exam["user_id"] . "</h6></td>";
                                                            echo "<td><h6>" . $tb_exam["id_exam"] . "</h6></td>";
                                                            echo "<td>" . $tb_exam["exam_runID"] . "</td>";
                                                            echo "<td>" . $tb_exam["exam_id"] . "</td>";
                                                            echo "<td>" . $tb_exam["exam_name"] . "</td>";
                                                            echo "<td>" . $tb_exam["numberofverses"] . "</td>";
                                                            echo "<td><span class='" . $statusClass . "'>" . $statusText . "</span></td>";
                                                            echo "<td>" . $tb_exam["autodatetime"] . "</td>";

                                                    ?>
                                                            <td>
                                                                <a style="color: red;" href="javascript:void(0);" onclick="confirmDelete(<?php echo $tb_exam['id_exam']; ?>)"><i class="fa fa-eraser"></i></a>
                                                            </td>

                                                            <!-- Include SweetAlert2 library -->
                                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                                                            <!-- Add the SweetAlert2 confirmation function -->
                                                            <script>
                                                                function confirmDelete(id) {
                                                                    Swal.fire({
                                                                        title: 'ต้องการลบข้อมูลหรือไม่?',
                                                                        text: 'ข้อมูลรายงานการประมวลผลของไอดีนี้จะถูกลบไปด้วย!',
                                                                        footer: 'คุณจะไม่สามารถกู้คืนข้อมูลได้!',
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonColor: '#d33',
                                                                        cancelButtonColor: '#3085d6',
                                                                        confirmButtonText: 'ใช่, ลบ!',
                                                                        cancelButtonText: 'ยกเลิก'
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            // If the user clicks 'Yes', redirect to the delete script
                                                                            window.location.href = '../back-end/admin_delete_exam.php?id_exam=' + id;
                                                                        }
                                                                    });
                                                                }
                                                            </script>

                                                    <?php
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='5'>ไม่พบข้อมูลในตาราง</td></tr>";
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
</body>

</html>