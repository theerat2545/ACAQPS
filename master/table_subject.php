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

    <style>
         h6 {
            color: red;
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
                                <a class="nav-link" href="table_users.php"><i class="fa fa-user fs-5 me-2"></i><span>ผู้ใช้</span></a>
                                <a class="nav-link" href="#"><i class="fa-solid fa-layer-group fs-5 me-2"></i><span>วิชา</span></a>
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
                                    ข้อมูลรายวิชา
                                </div>
                                <div class="card-body">
                                    <div
                                        class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                        <?php
                                        $search = isset ($_GET['search']) ? $_GET['search'] : '';
                                        $sql = "SELECT * FROM tb_subject WHERE sub_id LIKE '%$search%' OR SubjectID LIKE '%$search%' OR SubjectName LIKE '%$search%'";
                                        $result = $conn->query($sql);
                                        $total_records = $result->num_rows;

                                        $records_per_page = 10;
                                        $total_pages = ceil($total_records / $records_per_page);

                                        $page = isset ($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($page - 1) * $records_per_page;

                                        $sql = "SELECT * FROM tb_subject WHERE sub_id LIKE '%$search%' OR SubjectID LIKE '%$search%' OR SubjectName LIKE '%$search%' LIMIT $offset, $records_per_page";
                                        $result = $conn->query($sql);
                                        ?>
                                        <div class="datatable-top">
                                            <button type="button" class="btn"
                                                style="background-color: #1F2336; color:#fff" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"><i class="fa fa-plus"></i>
                                                เพิ่มรายวิชา</button>
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
                                                        <th data-sortable="true" style="width: 100px;"><a href="#"
                                                                class="datatable-sorter">ไอดี</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">รหัสวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">ชื่อวิชา</a></th>
                                                        <th data-sortable="true" style="width: auto;"><a href="#"
                                                                class="datatable-sorter">เครื่องมือ</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // ตรวจสอบว่ามีข้อมูลในตารางหรือไม่
                                                    if ($result->num_rows > 0) {
                                                        // แสดงข้อมูลทีละแถว
                                                        while ($tb_subject = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td><h6>" . $tb_subject["sub_id"] . "</h6></td>";
                                                            echo "<td>" . $tb_subject["SubjectID"] . "</td>";
                                                            echo "<td>" . $tb_subject["SubjectName"] . "</td>";
                                                            ?>
                                                            <td class="d-flex justify-content-center gap-3">
                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#editsub"
                                                                    onclick="Edit('<?php echo $tb_subject['sub_id']; ?>')">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a href="#" style="color: red;"
                                                                    onclick="confirmDelete('<?php echo $tb_subject['sub_id']; ?>')">
                                                                    <i class="fa fa-eraser"></i>
                                                                </a>
                                                            </td>
                                                            <?php
                                                            echo "</tr>";
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

    <!-- ======================================= Modal add subject ================================================= -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1F2336; color:#fff">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มรายวิชา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../back-end/add_subject.php" method="post">
                    <?php
                            $counter = 1;
                            $max = 999;
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            for ($i = 0; $i < $max; $i++) {
                                $id = sprintf("s%03u", $counter);
                                $sql = "SELECT * FROM `tb_subject` WHERE sub_id = '$id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $counter++;
                                    continue;
                                }
                                $counter++;
                                break;
                            }
                            ?>
                        <label for="id" class="label d-flex flex-column">ไอดี
                            <input class="text" type="text" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>"
                                readonly>
                        </label>
                        <label for="SubjectID" class="label d-flex flex-column">รหัสวิชา
                            <input class="text" type="text" name="SubjectID" id="SubjectID" placeholder="รหัสวิชา"
                                required>
                        </label>
                        <label for="SubjectName" class="label d-flex flex-column">ชื่อวิชา
                            <input class="text" type="text" name="SubjectName" id="SubjectName" placeholder="ชื่อวิชา"
                                required>
                        </label>
                        <br><br>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn" name="add_subject" style="background-color: #1F2336; color:#fff"><i
                                    class="fa fa-save"></i> บันทึก</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"
                                style="color:#fff"><i class="fa fa-times"></i> ปิด</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================= Modal edit subject ================================================= -->
    <div class="modal fade" id="editsub" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #1F2336; color:#fff">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขวิชา</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../back-end/update_subject.php">
                        <input class="text" type="text" name="sub_id" id="sub_id" hidden>
                        <label class="d-flex flex-column justify-content-center">รหัสวิชา:
                            <input class="text" type="text" name="examid" id="examid" required>
                        </label>
                        <label class="d-flex flex-column justify-content-center">ชื่อวิชา:
                            <input class="text" type="text" name="subname" id="subname" required>
                        </label>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary me-4" type="button"
                                onclick="clearInputFields()">เคลียร์ข้อมูล</button>
                            <button class="btn me-4" type="submit"
                                style="background-color: #1F2336; color:#fff">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(sub_id) {
            Swal.fire({
                title: 'คุณแน่ใจที่จะลบข้อมูลนี้?',
                text: 'การลบข้อมูลนี้ไม่สามารถย้อนกลับได้!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบข้อมูล!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../back-end/delete_subject_db.php?sub_id=' + sub_id;
                }
            });
        }

        function Edit(SubjectID) {
            // Assume you have variables for each field in the modal
            var sub_id = document.getElementById('sub_id');
            var examid = document.getElementById('examid');
            var subName = document.getElementById('subname');

            // Use AJAX to fetch subject data from the server
            $.ajax({
                type: 'POST',
                url: '../back-end/fetch_subject_data.php',
                data: {
                    subjectId: SubjectID
                },
                dataType: 'json',
                success: function (subjectData) {
                    // Populate the modal fields with subject data
                    sub_id.value = subjectData.sub_id;
                    examid.value = subjectData.SubjectID;
                    subName.value = subjectData.SubjectName;

                    // Show the modal
                    $('#editsub').modal('show');
                },
                error: function () {
                    alert('Error fetching subject data');
                }
            });
        }

        // $(document).ready(function () {
        //     // Handle form submission
        //     $("#editsub").submit(function (event) {
        //         // Prevent the default form submission
        //         event.preventDefault();

        //         // Get form data
        //         var subid = $("#subid").val();
        //         var subname = $("#subname").val();

        //         // TODO: Perform any validation if needed

        //         // Send the data to the server for updating in the database
        //         $.ajax({
        //             type: "POST", // You may need to adjust the method based on your backend
        //             url: "../back-end/update_subject.php", // Replace with the actual server-side script
        //             data: {
        //                 subid: subid,
        //                 subname: subname
        //             },
        //             success: function (response) {
        //                 // Handle the server response, e.g., show a success message
        //                 alert("Subject updated successfully!");
        //             },
        //             error: function (error) {
        //                 // Handle errors, e.g., show an error message
        //                 alert("Error updating subject. Please try again.", error);
        //             }
        //         });
        //     });
        // });

        function clearInputFields() {
            var examid = document.getElementById('examid');
            var subName = document.getElementById('subname');

            // Clear the values of the input fields
            examid.value = '';
            subName.value = '';
        }
    </script>

    <!-- <script src="../src/js/script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>