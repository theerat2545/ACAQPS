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

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // สมมุติว่า user_id ถูกเก็บไว้ใน session

if ($user_id > 0) {
    $sql = "SELECT * FROM tb_user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = $row; // กำหนดค่าแถวที่ดึงได้ให้กับตัวแปร $user
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css">
    <link href="src/css/styles.css" rel="stylesheet">
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!-- <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> -->

    <style>
        .sb-sidenav-footer a:hover {
            color: red;
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

        /* styles.css */
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
                /* Change flex direction */
            }

            .sidebarToggle {
                order: -1;
                /* Move sidebar toggle button to the top */
            }
            span{
                width: auto;
                height: auto;

            }
        }
    </style>
</head>

<body style="background-color: #DCDCDC;" class="sb-nav-fixed">

    <!-- ============================================== top bar ===================================================== -->
    <div class="container">
        <div style="border-bottom-right-radius: 5px; height: 7%;"
            class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex flex-row justify-content-between">
            <div class="d-flex flex-row">
                <a style="padding: 20px 24px 10px 24px; margin-left: 35px; margin-right: 35px;"
                    class="logo-name text-light d-flex justify-content-center text-decoration-none" href="home.php">
                    <h2
                        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: aliceblue;">
                        ACAQPS</h2>
                </a>
                <button style="padding: 10px 20px 10px 10px;"
                    class="btn btn-link d-flex flex-column justify-content-center" id="sidebarToggle" href="#!">
                    <i style="color:#fff; " class="fa-solid fa-bars"></i>
                </button>
                <span class="text-center d-flex flex-column justify-content-center"
                    style="font-size: 18px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: aliceblue;">
                    Answer checking and quality processing system</span>
            </div>
            <div class="d-flex flex-row">
                <a class="d-flex flex-column justify-content-center" href="profile.php?id=<?php echo $user_id ?>">
                    <?php if (isset($profileImage)): ?>
                        <!-- Display user profile image if available -->
                        <img width="55px" height="55px" src="<?php echo $profileImage; ?>" alt="Profile Image">
                    <?php else: ?>
                        <!-- Display default profile image if no profile image is available -->
                        <img width="55px" height="55px" src="./src/profile/profile.png" alt="Default Profile Image">
                    <?php endif; ?>
                </a>
                <div class="d-flex flex-column me-5 ms-3">
                    <?php if (isset($user)): ?>
                        <span class="text-light ">Name:<code
                                class="text-warning ms-1"><?php echo $_SESSION['user_name']; ?></code></span>
                        <span class="text-light ">Logged in as:<code
                                class="text-warning ms-1"><?php echo $user['user_level']; ?></code></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================= script ======================================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="src/js/scripts.js"></script>
    <script src="src/js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"crossorigin="anonymous"></script>
    <!-- <script src="https://kit.fontawesome.com/cd0c7e1c93.js" crossorigin="anonymous"></script> -->
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
    <script src="https://kit.fontawesome.com/cd0c7e1c93.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>