<?php
include "config.php";
include "src/topnav.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10"> -->
    <style>
        :where(input[type="file"]) {
            inline-size: 100%;
            max-inline-size: max-content;
            background-color: var(--_input-well);
        }

        .pro {
            width: 250px;
            height: 250px;
            margin: 3% 45% auto 42%;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
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
                        <div class="sb-sidenav-menu-heading pt-3  mt-3">menu bar</div>
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
                    <br><br>
                    <div style="background-color: red;" class="row ms-3 me-3">
                        <div style="background-color: #eee; " class="d-flex flex-column justify-content-center">
                            <div class="d-flex justify-content-between">
                                <label class="ms-2 mt-2">
                                    <input class="text" type="text" name="user_id" id="user_id"
                                        value="UserId : <?php echo $user_id; ?>" disabled="disabled" readonly>
                                </label>
                            </div>
                            <?php if (isset($profileImage)): ?>
                                <!-- ให้รูปโปรไฟล์แสดงใน topbar ถ้ามี -->
                                <img class="pro" src="<?php echo $profileImage; ?>" alt="Profile Image">
                            <?php else: ?>
                                <!-- ถ้าไม่มีรูปโปรไฟล์ให้ใช้รูปโปรไฟล์ที่ default -->
                                <img class="pro" src="./src/profile/profile.png" alt="">
                            <?php endif; ?>
                            <br>
                                <div class="row mb-3">
                                    <div class="col-3"></div>
                                    <div class="col-6">
                                        <label class="mt-4 me-3 mb-4 d-flex justify-content-center">
                                            <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                class="text-primary fs-18">แก้ไขรหัสผ่าน</a>
                                        </label>
                                    </div>
                                    <div class="col-3"></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                </div> -->
                        </div>
                    </div>
                </div>
        </div>
        </main>
    </div>

    <!--================================ MODAL EDIT PASSWORD ==============================================-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1F2336; color:#fff">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขรหัสผ่าน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-container register-container ">
                        <form action="back-end/forgot_password.php" method="post">

                            <label for="userid" class="label d-flex flex-column">
                                ไอดี
                                <input class="text" type="text" name="userid" value="<?php echo $user_id; ?>" readonly>
                            </label>

                            <label for="username" class="label d-flex flex-column">ยูสเซอร์เนม
                                <input class="text" type="text" name="email"
                                    value="<?php echo $_SESSION['user_username']; ?>" required>
                            </label>
                            <label for="password" class="label d-flex flex-column">รหัสผ่าน
                            <input class="text" type="password" name="password" placeholder="password" required>
                            </label>
                            <br>
                            <div class="d-flex justify-content-end gap-2">
                                <button style="background-color: #1F2336; color:#fff" class="btn" type="submit"><i
                                        class="fa fa-save"></i> ตกลง</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                        class="fa fa-xmark"></i> ปิด</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>