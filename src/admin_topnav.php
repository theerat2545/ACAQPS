<?php
session_start();
if (!isset($_SESSION['user_level'])) {
    $_SESSION['msg'] = "You must lon in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_level']);
    header('location: login.php');
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Assuming the user_id is stored in the session

if ($user_id > 0) {
    // Retrieve user data
    $sql = "SELECT user_firstname, user_level FROM tb_user WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = $row; // Assign the fetched row to $user variable
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css">
    <link href="../src/css/styles.css" rel="stylesheet">
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <style>
        .sb-sidenav-footer a:hover {
            color: red;
        }

        span {
            color: #ddd;
        }

        ul li {
            list-style: none;
        }

        .treeview-menu {
            display: none;
        }

        nav li a {
            position: relative;
            display: block;
            padding: 10px 15px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-name {
            padding: 20px 24px 10px 24px;
            margin-left: 35px;
            margin-right: 35px;
        }

        .sidebarToggle {
            padding: 10px 20px 10px 10px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebarToggle {
                order: -1;
            }

            span {
                width: auto;
                height: auto;
            }
        }

        .line {
            border-right: 1px solid slategray;
            padding-right: 0.3rem;
        }

        .nav-link:hover{
            color: #fff;
        }
        .menu{
            color: #dcdcdc;
        }
        .menu:hover{
            color: #fff;
        }
        .logout{
            color: #fff;
        }
        .logout:hover{
            color: #FA0429;
        }
    </style>
</head>

<body style="background-color: #DCDCDC;" class="sb-nav-fixed">

    <!-- ============================================== top bar ===================================================== -->
    <div>
        <div style="border-bottom-right-radius: 5px; height: 7%;"
            class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex flex-row justify-content-between">
            <div class="d-flex flex-row">
                <a style="padding: 20px 24px 10px 24px; margin-left: 35px; margin-right: 35px;"
                    class="logo-name text-light d-flex justify-content-center text-decoration-none"
                    href="dashboard.php">
                    <h2
                        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: aliceblue;">
                        ผู้ดูแลระบบ</h2>
                </a>
                <div class="nav fs-5">
                    <a style="padding: 24px 16px 16px 16px;" class="nav-link menu" href="dashboard.php">
                        <div class="sb-nav-link-icon d-flex"><i class="fa-solid fa-chart-simple ms-3 fs-4 pe-2 menu"></i><span>แดชบอร์ด</span></div>
                        <div class="sb-sidenav-collapse-arrow"></div>
                    </a>
                    <a style="padding: 24px 16px 16px 16px" class="nav-link menu" href="manage_user.php">
                        <div class="sb-nav-link-icon d-flex"><i class="fa-solid fa-user-pen ms-3 fs-4 pe-2 menu"></i><span>จัดการข้อมูลรายวิชาของผู้สอน</span></div>
                        <div class="sb-sidenav-collapse-arrow"></div>
                    </a>
                    <!-- <a style="padding: 24px 16px 16px 16px;" class="nav-link menu" href="issue_user.php">
                        <div class="sb-nav-link-icon d-flex"><i class="fa-solid fa-clipboard ms-3 fs-4 pe-2 menu"></i><span>ปัญหาจากผู้ใช้</span></div>
                        <div class="sb-sidenav-collapse-arrow"></div>
                    </a> -->

                    <a style="padding: 24px 16px 16px 16px;" class="nav-link d-flex menu" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
                        <div class="sb-nav-link-icon d-flex"><i class="fa-solid fa-table ms-3 fs-4 pe-2 menu"></i><span>รายงานข้อมูล</span></div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color:#ddd" class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav style="position:absolute; left:890px; top:50px" class="sb-sidenav-menu-nested nav d-flex flex-column bg-dark">
                            <a class="nav-link menu" href="table_users.php"><i
                                    class="fa fa-user fs-5 me-2 menu"></i><span>ผู้ใช้</span></a>
                            <a class="nav-link menu" href="table_subject.php"><i
                                    class="fa-solid fa-layer-group fs-5 me-2 menu"></i><span>รายวิชา</span></a>
                            <a class="nav-link menu" href="table_exam.php"><i
                                    class="fa-solid fa-scroll fs-5 me-2 menu"></i><span>ข้อสอบที่ลงทะเบียน</span></a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <a class="nav-link pt-1" href="#">
                    <img width="55px" height="55px" src="../src/img/admin.png" alt="profile">
                </a>
                <div class="d-flex flex-column me-5 ms-2 pt-1">
                    <?php if (isset($user)): ?>
                        <span class="text-light ">Name:<code
                                class="text-info ms-1"><?php echo $user['user_firstname']; ?></code></span>
                        <span class="text-light ">Logged in as:<code
                                class="text-info ms-1"><?php echo $user['user_level']; ?></code></span>
                    <?php endif; ?>
                </div>
                <span class="line"></span>
                <a style="padding: 24px 16px 16px 16px;" class="nav-link d-flex" href="../back-end/logout_admin.php">
                    <div class="sb-nav-link-icon d-flex"><i class="fa-solid fa-sign-out fs-4 logout"></i></div>
                </a>
            </div>

        </div>
    </div>

    <!-- ============================================= script ======================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/cd0c7e1c93.js" crossorigin="anonymous"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>