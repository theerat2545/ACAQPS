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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        h6 {
            color: red;
        }
    </style>
</head>

<body>
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
    <!-- ============================================== sidenav ===================================================== -->
    <div class="pt-4">

        <!-- ============================================== sidenav-menu ===================================================== -->
        <!-- <div style="width: 12%; height: 100%;" class="d-block" id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav fs-5">
                        <div class="sb-sidenav-menu-heading pt-3  mt-3">menu bar</div>
                        <a style="padding: 20px 16px 20px 16px;" class="nav-link " href="dashboard.php">
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
                                <a class="nav-link" href="#"><i class="fa fa-user fs-5 me-2"></i><span>ผู้ใช้</span></a>
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
                </div>

            </nav>
        </div> -->

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
                                    ข้อมูลผู้ใช้
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <?PHP
                                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                                        $user_level = "member";
                                        $sql = "SELECT * FROM tb_user WHERE user_level = '$user_level'AND (user_id LIKE '%$search%' OR user_prefix LIKE '%$search%' OR user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%' OR user_level LIKE '%$search%')";
                                        $total_records = $result->num_rows;

                                        $records_per_page = 15;
                                        $total_pages = ceil($total_records / $records_per_page);

                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;

                                        $sql = "SELECT * FROM tb_user WHERE user_level = '$user_level'AND (user_id LIKE '%$search%' OR user_prefix LIKE '%$search%' OR user_firstname LIKE '%$search%' OR user_lastname LIKE '%$search%' OR user_level LIKE '%$search%') LIMIT $offset, $records_per_page";
                                        $result = $conn->query($sql);
                                        ?>
                                        <div class="datatable-top">
                                            <button type="button" class="btn"
                                                style="background-color: #1F2336; color:#fff;" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"><i class="fa fa-plus"></i>
                                                สร้างผู้ใช้</button>
                                            <div class="datatable-search d-flex flex-row gap-2">
                                                <form style="display:flex; margin-block-end: 0 !important" action=""
                                                    method="get">
                                                    <input name="search" class="datatable-input" placeholder="Search..."
                                                        type="search" title="Search within table"
                                                        aria-controls="datatablesSimple">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="fa fa-search"></i></button>
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
                                                                class="datatable-sorter">ชื่อ-นามสกุล</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">ตำแหน่ง</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">วันเวลาที่ลงทะเบียน</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">เครื่องมือ</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
                                                    if ($result->num_rows > 0) {
                                                        // แสดงข้อมูลทีละแถว
                                                        while ($tb_user = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td><h6>" . $tb_user["user_id"] . "</h6></td>";
                                                            echo "<td>" . $tb_user["user_prefix"] . ' ' . $tb_user["user_firstname"] . " " . " " . $tb_user["user_lastname"] . "</td>";
                                                            echo "<td>" . $tb_user["user_level"] . "</td>";
                                                            echo "<td>" . $tb_user["regis_datetime"] . "</td>";

                                                            ?>
                                                            <td class="d-flex justify-content-center gap-3">
                                                                <!-- Modify your Edit button to include the user ID and call the confirmEdit function -->
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                    data-bs-target="#editModal"
                                                                    onclick="confirmEdit('<?php echo $tb_user['user_id']; ?>')">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a href="javascript:void(0);" style="color:red"
                                                                    onclick="confirmDelete('<?php echo $tb_user['user_id']; ?>')"><i
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
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!--====================================== Add User Modal ================================================-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1F2336; color:#fff">
                    <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-container register-container ">
                        <form action="../back-end/regis_db.php" method="post">
                            <?php
                            $counter = 1;
                            $max = 999;
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            for ($i = 0; $i < $max; $i++) {
                                $userid = sprintf("u%03u", $counter);
                                $sql = "SELECT * FROM `tb_user` WHERE user_id = '$userid'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $counter++;
                                    continue;
                                }
                                $counter++;
                                break;
                            }
                            ?>
                            <label for="userid" class="label d-flex flex-column">
                                ไอดี
                                <input class="text" type="text" name="userid"
                                    value="<?php echo isset($userid) ? $userid : ''; ?>" readonly>
                            </label>
                            <label for="username" class="label d-flex flex-column">ยูสเซอร์เนม
                                <input class="text" type="text" name="email" placeholder="ยูสเซอร์เนม" required>
                            </label>
                            <label for="password" class="label d-flex flex-column">รหัสผ่าน
                                <input class="text" type="password" name="password" placeholder="รหัสผ่าน" required>
                            </label>
                            <div class="d-flex justify-content-start gap-3">
                                <label for="prefix" class="label d-flex flex-column">คำนำหน้าชื่อ
                                    <select style="height: 45px;" name="prefix" id="prefix">
                                        <option disabled="disabled">--select--</option>
                                        <option value="อาจารย์">อาจารย์</option>
                                        <option value="ดร.">ดร.</option>
                                        <option value="ศาสตราจารย์">ศาสตราจารย์</option>
                                    </select>
                                </label>
                                <label for="fistname" class="label d-flex flex-column">ชื่อจริง
                                    <input class="text" type="text" name="firstname" placeholder="ชื่อจริง" required>
                                </label>
                            </div>
                            <label for="lastname" class="label d-flex flex-column">นามสกุล
                                <input class="text" type="text" name="lastname" placeholder="นามสกุล" required>
                            </label>
                            <br>
                            <div class="d-flex justify-content-end gap-2">
                                <button style="background-color: #1F2336; color:#fff" class="btn" name="reg_user"
                                    type="submit"><i class="fa fa-save"></i>
                                    ตกลง</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                        class="fa fa-xmark"></i> ปิด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--================================ Edit Modal ====================================================-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1F2336; color:#fff">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-container register-container">
                        <form action="../back-end/edit_user_db.php" method="post">
                            <label for="editUserid" class="label d-flex flex-column">
                                User ID
                                <input class="text" type="text" name="editUserid" id="editUserid" readonly>
                            </label>
                            <label for="editEmail" class="label d-flex flex-column">Username
                                <input class="text" type="text" name="editEmail" id="editEmail" readonly>
                            </label>
                            <div class="d-flex justify-content-start gap-3">
                                <label for="editPrefix" class="label d-flex flex-column">Prefix
                                    <select style="height: 45px;" name="editPrefix" id="editPrefix">
                                        <option disabled="disabled">--select--</option>
                                        <option value="อาจารย์">อาจารย์</option>
                                        <option value="ดร.">ดร.</option>
                                        <option value="ศาสตราจารย์">ศาสตราจารย์</option>
                                    </select>
                                </label>
                                <label for="editFirstname" class="label d-flex flex-column">First
                                    Name
                                    <input class="text" type="text" name="editFirstname" id="editFirstname">
                                </label>
                            </div>
                            <label for="editLastname" class="label d-flex flex-column">Last Name
                                <input class="text" type="text" name="editLastname" id="editLastname">
                            </label>
                            <br>
                            <div class="d-flex justify-content-end gap-2">
                                <button style="background-color: #1F2336; color:#fff" class="btn" name="edit_user"
                                    type="submit"><i class="fa fa-save"></i>
                                    ตกลง</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                        class="fa fa-times"></i> ปิด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmEdit(user_id) {
            // Assume you have variables for each field in the modal
            var editUserId = document.getElementById('editUserid');
            var editEmail = document.getElementById('editEmail');
            var editPrefix = document.getElementById('editPrefix');
            var editFirstname = document.getElementById('editFirstname');
            var editLastname = document.getElementById('editLastname');

            // Use AJAX to fetch user data from the server
            $.ajax({
                type: 'POST',
                url: '../back-end/fetch_user_data.php',
                data: {
                    userId: user_id
                },
                dataType: 'json',
                success: function (userData) {
                    // Populate the modal fields with user data
                    editUserId.value = userData.user_id;
                    editEmail.value = userData.user_username;
                    editPrefix.value = userData.user_prefix;
                    editFirstname.value = userData.user_firstname;
                    editLastname.value = userData.user_lastname;

                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function () {
                    alert('Error fetching user data');
                }
            });
        }

        function confirmDelete(user_id) {
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
                    window.location.href = '../back-end/delete_user_db.php?user_id=' + user_id;
                }
            });
        }
    </script>
    <!-- <script src="/src/js/script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>