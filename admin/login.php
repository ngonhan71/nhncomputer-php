<?php 
     if (!defined('BASE_URL_ADMIN')) {
        define('BASE_URL_ADMIN', './');
    }

    if (!defined('BASE_URL')) {
        define('BASE_URL', '../');
    }
  
?>

<?php

    include_once BASE_URL."database/dbhelper.php";
    session_start();
   
    if (isset($_POST['submit-login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashPassword = md5($password);
        $sqlLogin = "select * from administrator where email = ? and password = ?";
        $data = executeGetDataBindParam($sqlLogin, "ss", [$email, $hashPassword]);

        if (count($data) > 0) {
            $_SESSION['email'] = $email;
            header("Location: ./index.php");
        }
        else {
            $message = 'Thất bại! Tài khoản hoặc mật khẩu không đúng!';
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <style>
        .login-message.error {
            color: #dc3545;
            text-align: center;
            margin: 0;
        }
    </style>
    <title>Document</title>
</head>
<body class="bg-light bg-gradient">
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Xem Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="main py-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 offset-xl-4">
                    <p class="h3 text-center">ĐĂNG NHẬP HỆ THỐNG</p>
                    <p class="login-message error"><?php if (isset($message)) echo $message; ?></p>
                </div>
                <form action="" method="POST" id="form-login"> 
                    <div class="col-xl-4 offset-xl-4">
                        <label for="input-email" class="form-label">Email</label>
                        <input name="email" required type="email" class="form-control" id="input-email" placeholder="Tài khoản">
                        <div class="valid-feedback"> Looks good!</div>
                    </div>
                    <div class="col-xl-4 offset-xl-4">
                        <label for="input-password" class="form-label">Password</label>
                        <input name="password" required type="password" class="form-control" id="input-password" placeholder="Mật khẩu">
                    </div>
                    <button type="submit" name="submit-login" class="btn btn-danger offset-xl-4 mt-3">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>

</body>
