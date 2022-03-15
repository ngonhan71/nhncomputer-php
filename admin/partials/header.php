<?php

    if (!defined('BASE_URL_ADMIN')) {
        define('BASE_URL_ADMIN', './');
    }

    if (!defined('BASE_URL')) {
        define('BASE_URL', '../');
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once BASE_URL."database/dbhelper.php";
    include_once BASE_URL."utility/utility.php";

    // Kiem tra admin
    $isNext = false;
    if (!empty($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $isNext = middlewareisRoleAdmin($email);

        $sql = "select * from administrator where email = ?";
        $admin = executeGetDataBindParam($sql, "s", [$email]);
        $adminInfo = $admin[0];
    }
    if (!$isNext) {
        header("Location: ".BASE_URL_ADMIN."login.php");
    }   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=BASE_URL_ADMIN?>public/css/base.css">
    <title>NHN COMPUTER - Quản trị viên</title>
</head>
<body>

    <div class="admin-wrapper">
        <nav class="nav">
            <ul class="navbar full">
                <li class="nav-item bars">
                    <a href=""><i class="fa-solid fa-bars"></i></i></a>
                </li>
                <li class="nav-item">
                    <a href="">Home</a>
                </li>
                <li class="nav-item">
                    <a href="">Contact</a>
                </li>
            </ul>

            <ul class="navbar ml-auto">
                <li class="nav-item">
                    <a href="<?=BASE_URL_ADMIN?>logout.php">Đăng xuất</a>
                </li>
            </ul>

        </nav>

        <!--  -->

        <div class="main-sidebar">
            <div class="logo">
                <a href="">
                    <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="">
                    <span>Admin <?=$adminInfo['given_name']?></span>
                </a>
            </div>
            <div class="sidebar-container">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="<?=BASE_URL_ADMIN?>index.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tổng quan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=BASE_URL_ADMIN?>">
                            <i class="fa-regular fa-user"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=BASE_URL_ADMIN?>product/index.php">
                            <i class="fa-solid fa-keyboard"></i>
                            <span>Sản phẩm</span>
                            <i class="icon-open fa-solid fa-plus fa-minus"></i>
                        </a>
                        <ul class="subnav">
                            <li class="nav-item">
                                <a  href="<?=BASE_URL_ADMIN?>product/index.php">
                                  <i class="fa-solid fa-minus"></i>
                                    <span>Quản lý sản phẩm</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?=BASE_URL_ADMIN?>product/add.php">
                                  <i class="fa-solid fa-minus"></i>
                                    <span>Thêm sản phẩm mới</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?=BASE_URL_ADMIN?>product/add-review.php">
                                  <i class="fa-solid fa-minus"></i>
                                    <span>Thêm bài viết</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?=BASE_URL_ADMIN?>cart/index.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=BASE_URL_ADMIN?>ChangePassword.php">
                            <i class="fa-solid fa-keyboard"></i>
                            <span>Đổi mật khẩu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <script>
        const navItemSideBar = $('.main-sidebar .nav-list > .nav-item')

        $('.main-sidebar .nav-list .nav-item .icon-open').click(function(e) {
            e.preventDefault();
            e.stopPropagation()
            $(this).toggleClass('fa-plus')
            console.log($(this).parent().next('.subnav').slideToggle(200))
        })

        const isCollapse = localStorage.getItem('collapse') || 'true'

        if (isCollapse == 'true') {
            if ($('.main-sidebar').hasClass('active')) {
                $('.main-sidebar').removeClass('active')
            }

            if (!$('.admin-wrapper .nav').hasClass('full')) {
                $('.admin-wrapper .nav').addClass('full')
            }
        } else {
                if (!$('.main-sidebar').hasClass('active')) {
                    $('.main-sidebar').addClass('active')
                }
                
                if ($('.admin-wrapper .nav').hasClass('full')) {
                    $('.admin-wrapper .nav').removeClass('full')
                }
        }

        $('.nav .navbar .nav-item.bars').click(function(e) {
            e.preventDefault();
           $('.main-sidebar').toggleClass('active')
           $('.admin-wrapper .nav').toggleClass('full')
           if ($('.main-sidebar').hasClass('active')) {
               localStorage.setItem('collapse', 'false')
           } else {
                localStorage.setItem('collapse', 'true')
           }
        })



    </script>