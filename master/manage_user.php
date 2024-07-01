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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .datatable-top {
            padding-bottom: 0 !important;
            padding-right: 20px;
        }

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
                    <h1 class="">จัดการข้อมูลรายวิชาของผู้สอน</h1>
                    <div class="card bg-white mb-4 ">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-container">
                                    <form action="../back-end/insert_manage_db.php" method="post">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="">ไอดีผู้ใช้</label>
                                                <select class="form-select" name="user" id="user" required>
                                                    <option value="">--โปรดเลือก--</option>
                                                    <?php
                                                    $sql = "SELECT user_id, user_firstname, user_lastname FROM tb_user WHERE user_level = 'member'";
                                                    $result = $conn->query($sql);

                                                    if ($result && $result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $user_id = $row['user_id'];
                                                            $userfirstname = $row['user_firstname'];
                                                            $userlastname = $row['user_lastname'];
                                                            echo "<option value=\"$user_id\">$user_id - $userfirstname - $userlastname</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <label for="">ชื่อจริง</label>
                                                <input class="form-control" name="userfname" id="userfname" type="text"
                                                    readonly required>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <label for="">นามสกุล</label>
                                                <input class="form-control" name="userlname" id="userlname" type="text"
                                                    readonly required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="">ไอดี</label>
                                                <select class="form-select" name="sub" id="sub" required>
                                                    <option value="">--โปรดเลือก--</option>
                                                    <?php
                                                    $sql = "SELECT sub_id, SubjectID, SubjectName FROM tb_subject";
                                                    $result = $conn->query($sql);

                                                    if ($result && $result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $subid = $row['sub_id'];
                                                            $subjectID = $row['SubjectID'];
                                                            $subjectName = $row['SubjectName'];
                                                            echo "<option value=\"$subid\">$subid - $subjectID - $subjectName</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <label for="">รหัสวิชา</label>
                                                <input class="form-control" name="subid" id="subid" type="text" readonly
                                                    required>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <label for="">ชื่อวิชา</label>
                                                <input class="form-control" name="subname" id="subname" type="text"
                                                    readonly required>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-11"></div>
                                            <div class="col-1 d-flex justify-content-end">
                                                <input value="เพิ่ม" type="submit" class="btn btn-success ">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white">
                    <?php
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $searchField = isset($_GET['searchField']) ? $_GET['searchField'] : 'all';
                    $sql = "SELECT * FROM tb_userandsubject WHERE ";
                    if ($searchField !== 'all') {
                        $sql .= "$searchField LIKE '%$search%'";
                    } else {
                        // ถ้า searchField เป็น 'all' ให้ค้นหาข้อมูลในทุกฟิลด์ที่เป็นตัวเลขหรือข้อความ
                        $sql .= "us_id LIKE '%$search%' OR user_id LIKE '%$search%' OR sub_id LIKE '%$search%' OR subjectID LIKE '%$search%' OR subjectName LIKE '%$search%'";
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
                        <div class="card-header">
                            รายงานข้อมูลรายวิชาผู้สอน
                        </div>
                        <div class="datatable-top pt-2">
                            <div class="datatable-search d-flex flex-row gap-2">
                                <form style="display:flex; margin-block-end: 0 !important" action="" method="get">
                                        <select name="searchField" class="form-select me-1">
                                            <option value="all" <?php if ($searchField === 'all')
                                                echo 'selected'; ?>>ทั้งหมด
                                            </option>
                                            <option value="us_id" <?php if ($searchField === 'us_id')
                                                echo 'selected'; ?>>ไอดี</option>
                                            <option value="user_id" <?php if ($searchField === 'user_id')
                                                echo 'selected'; ?>>
                                                ไอดีผู้ใช้</option>
                                            <option value="sub_id" <?php if ($searchField === 'sub_id')
                                                echo 'selected'; ?>>
                                                ไอดีวิชา</option>
                                            <option value="subjectID" <?php if ($searchField === 'subjectID')
                                                echo 'selected'; ?>>
                                                รหัสวิชา</option>
                                            <option value="subjectName" <?php if ($searchField === 'subjectName')
                                                echo 'selected'; ?>>ชื่อวิชา</option>
                                        </select>
                               
                                        <input style="width: auto; margin:8px 0 8px 0" name="search" class="datatable-input"
                                            placeholder="Search..." type="search" title="Search within table"
                                            aria-controls="datatablesSimple">
                                        <button style="margin:auto auto auto 0" class="btn btn-primary" type="submit"><i
                                                class="fa fa-search"></i></button>
                                        <button style="margin:auto 0 auto 5px" class="btn btn-secondary" type="submit"
                                            onclick="resetSearch()"><i class="fa-solid fa-repeat"></i></button>
                                </form>
                                <script>
                                    // เลือก element ที่เกี่ยวข้อง
                                    var searchField = document.querySelector('select[name="searchField"]');
                                    var searchInput = document.querySelector('input[name="search"]');
                                    var searchForm = document.querySelector('form');

                                    // เมื่อมีการเปลี่ยนค่าใน select search ให้เปลี่ยน URL และ redirect
                                    searchField.addEventListener('change', function () {
                                        var urlParams = new URLSearchParams(window.location.search);
                                        urlParams.set('searchField', searchField.value);
                                        window.location.href = window.location.pathname + '?' + urlParams.toString();
                                    });

                                    function resetSearch() {
                                        var searchInput = document.querySelector('input[name="search"]');
                                        var searchField = document.querySelector('select[name="searchField"]');
                                        searchInput.value = ''; // Clear the search input
                                        searchField.value = 'all'; // Set the search field to 'all'
                                        searchForm.submit(); // Submit the form after resetting
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-container">
                                <table id="datatablesSimple" class="datatable-table">
                                    <thead style="background-color: #1F2336; color:#fff;">
                                        <tr>
                                            <th data-sortable="true" style="width: 10px;"><a href="#"
                                                    class="datatable-sorter">ไอดี</a></th>
                                            <th data-sortable="true" style="width: 200px;"><a href="#"
                                                    class="datatable-sorter">ไอดีผู้ใช้</a></th>
                                            <th data-sortable="true" style="width: 200px;"><a href="#"
                                                    class="datatable-sorter">ไอดีวิชา</a></th>
                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                    class="datatable-sorter">รหัสวิชา</a></th>
                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                    class="datatable-sorter">ชื่อวิชา</a></th>
                                            <th data-sortable="true" style="width: auto;"><a href="#"
                                                    class="datatable-sorter"></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
                                        if ($result->num_rows > 0) {
                                            // แสดงข้อมูลทีละแถว
                                            while ($tb_manage = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><h6>" . $tb_manage["us_id"] . "</h6></td>";
                                                echo "<td><h6>" . $tb_manage["user_id"] . "</h6></td>";
                                                echo "<td><h6>" . $tb_manage["sub_id"] . "</h6></td>";
                                                echo "<td>" . $tb_manage["subjectID"] . "</td>";
                                                echo "<td>" . $tb_manage["subjectName"] . "</td>";

                                                ?>
                                                <td class="d-flex justify-content-center gap-3">
                                                    <a href="javascript:void(0);" style="color:red"
                                                        onclick="confirmDelete('<?php echo $tb_manage['us_id']; ?>')"><i
                                                            class="fa fa-eraser"></i></a>
                                                </td>
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
        </main>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'ต้องการลบข้อมูลหรือไม่?',
                text: 'คุณจะไม่สามารถกู้คืนข้อมูลได้!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบ!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks 'Yes', redirect to the delete script
                    window.location.href = '../back-end/delete_manage_db.php?id=' + id;
                }
            });
        }

        document.getElementById("sub").addEventListener("change", function () {
            // ดึงค่าที่ถูกเลือกในเมนูดรอปดาวน์
            var selectedOption = this.options[this.selectedIndex];

            // ดึงรหัสวิชาและชื่อวิชา
            var id = selectedOption.value;
            var subjectID = selectedOption.textContent.split(" - ")[1];
            var subjectName = selectedOption.textContent.split(" - ")[2];

            // กำหนดค่าให้กับช่อง examname
            document.getElementById("subid").value = subjectID;
            document.getElementById("subname").value = subjectName;
        });
        document.getElementById("user").addEventListener("change", function () {
            // ดึงค่าที่ถูกเลือกในเมนูดรอปดาวน์
            var selectedOption = this.options[this.selectedIndex];

            // ดึงรหัสวิชาและชื่อวิชา
            var userid = selectedOption.value;
            var userfn = selectedOption.textContent.split(" - ")[1];
            var userln = selectedOption.textContent.split(" - ")[2];

            // กำหนดค่าให้กับช่อง examname
            document.getElementById("userfname").value = userfn;
            document.getElementById("userlname").value = userln;
        });
    </script>
</body>

</html>