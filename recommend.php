<?php
include "config.php";
include "src/topnav.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แนะนำการใช้งาน</title>
    <style>
        * {
            box-sizing: border-box
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Hide the images by default */
        .mySlides {
            display: none;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: black;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            text-decoration: none;
        }

        /* Position the "next button" to the right */
        .next {
            left: 100%;
            border-radius: 3px 0 0 3px;
            font-size: xxx-large;
        }

        .prev {
            right: 100%;
            border-radius: 3px 0 0 3px;
            font-size: xxx-large;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 1.5s;
            animation-name: fade;
            animation-duration: 1.5s;
        }

        .fade:not(.show) {
            opacity: 1 !important;
        }

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
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
                        <h1 class="pt-3">Recommended </h1>
                            <ol class="breadcrumb mb-2">
                                <li class="breadcrumb-item ps-3">แนะนำการใช้งาน</li>
                            </ol>
                            <div class="form-container bg-white mb-4">
                                <div class="row">
                                    <div class="col pt-5">
                                        <div class="slideshow-container d-flex justify-content-center">

                                            <div class="mySlides fade">
                                                <div class="numbertext">1 / 3</div>
                                                <div class="card" style="width: 1000px;">
                                                    <img src="src/img/Screenshot 2023-11-11 175013.png" style="width:100%">
                                                </div>
                                            </div>

                                            <div class="mySlides fade">
                                                <div class="numbertext">2 / 3</div>
                                                <div class="card" style="width: 1000px;">
                                                    <img src="src/img/Screenshot 2023-11-27 171105.png" style="width:100%">
                                                </div>
                                            </div>

                                            <div class="mySlides fade">
                                                <div class="numbertext">3 / 3</div>
                                                <div class="card" style="width: 1000px;">
                                                    <img src="src/img/1262248.jpg" style="width:100%">
                                                </div>
                                            </div>

                                            <!-- Next and previous buttons -->
                                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                        </div>
                                        <br>

                                        <!-- The dots/circles -->
                                        <div style="text-align:center">
                                            <span class="dot" onclick="currentSlide(1)"></span>
                                            <span class="dot" onclick="currentSlide(2)"></span>
                                            <span class="dot" onclick="currentSlide(3)"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col ps-5 pe-5 pt-5 pb-5">
                                        <h4>fffffffffffffff</h4>
                                        <span>xxxxxxxxxxx</span>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                </div>
        </div>
        </main>
    </div>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
</body>

</html>