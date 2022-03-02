<?php 
    define('BASE_URL', '../');
    $isRegisterPage = true;

    $titlePage = 'Tài khoản | NHN Computer';

    include_once BASE_URL."partials/header.php";

    // if (!empty($_SESSION['access_token'])) {
    //     echo("<script>location.href = '../index.php';</script>");
    // }

?>

<?php 
    // include_once BASE_URL."config.php";
    // require_once BASE_URL.'google-api-php-client/vendor/autoload.php';

    // $googleClient = new Google_Client();
    // $googleClient->setClientId(GOOGLE_CLIENT_ID);
    // $googleClient->setClientSecret(GOOGLE_CLIENT_SECRET);
    // $googleClient->setRedirectUri(GOOGLE_APP_CALLBACK_URL);
    // $googleClient->addScope("email");
    // $googleClient->addScope("profile");
?>
<?php

    // $authUrl = '';
    // if (empty($_SESSION['access_token'])) {
    //     $authUrl = $googleClient->createAuthUrl();
    // }
    // if ($googleClient->isAccessTokenExpired()) {
    //     $authUrl = $googleClient->createAuthUrl();

    // }

?>
<div class="main">
    <div class="auth">
       <div class="container">
            <h1 class="auth-heading">Đăng ký tài khoản</h1>
            <div class="register-input-email register">
                <form id="form-register" action="" method="POST">
                    <p class="message-request">Vui lòng nhập thông tin để đăng ký!</p>
                    <div class="form-group">
                        <label for="input-email" class="auth-icons fas fa-envelope"></label>
                        <input required id="input-email" type="email" class="form-control" placeholder="Nhập email (*)">
                    </div>
                  <div class="wrapper-name row">
                        <div class="col col-xl-6">
                            <div class="form-group">
                                <label for="input-email" class="auth-icons fas fa-user"></label>
                                <input required id="input-family-name" type="text" class="form-control" placeholder="Họ của bạn (*)">
                            </div>
                        </div>
                       <div class="col col-xl-6">
                            <div class="form-group">
                                <label for="input-email" class="auth-icons fas fa-user"></label>
                                <input required id="input-given-name" type="text" class="form-control" placeholder="Tên của bạn (*)">
                            </div>
                       </div>
                  </div>
                    <div class="row footer">
                        <div class="box-btn">
                            <button class="btn btn-submit" type="submit">Đăng ký</button>
                        </div>
                        <div class="loading">
                            <img src="<?=BASE_URL?>public/image/loading-2.gif" alt="">
                        </div>
                    </div>
                </form>
                <div class="action">
                    <span>Bạn đã có tài khoản? </span><a class="link-login" href="./login.php">Đăng nhập ngay tại đây!</a>
                </div>
            </div>
            <!-- <div class="register-customer-info register">
                <form id="form-register" action="" method="GET">
                    <div class="row">
                        <p class="message-request">Vui lòng nhập thông tin cá nhân và địa chỉ nhận hàng!</p>
                        <div class="col col-xl-6">
                            <div class="form-group">
                                <label for="input-fullname" class="auth-icons fas fa-user"></label>
                                <input id="input-email" type="email" class="form-control" placeholder="Họ và tên">
                            </div>
                            <div class="form-group">
                                <label for="input-fullname" class="auth-icons fas fa-lock"></label>
                                <input id="input-email" type="email" class="form-control" placeholder="Mật khẩu">
                            </div>
                            <div class="form-group">
                                <label for="input-fullname" class="auth-icons fas fa-lock"></label>
                                <input id="input-email" type="email" class="form-control" placeholder="Nhập lại mật khẩu">
                            </div>
                            <button class="btn" type="submit">Đăng ký</button>
                        </div>
                        <div class="col col-xl-6">
                            <div class="row">
                                <div class="col col-xl-6">
                                    <div class="form-group">
                                        <select name="" id="province">
                                            <option value="">Tỉnh / thành</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col col-xl-6">
                                    <div class="form-group">
                                        <select name="" id="district">
                                            <option value="">Quận / huyện</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-xl-6">
                                    <div class="form-group">
                                        <select name="" id="ward">
                                            <option value="">Phường / xã</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-xl-12">
                                    <div class="form-group">
                                        <input id="input-address" type="email" class="form-control" placeholder="Số, đường, khu phố">
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </form>
            </div> -->
       </div>
    </div>
</div>
<!-- <div class="main">
    <div class="auth">
        <div class="container">
            <h1 class="auth-heading">Đăng nhập</h1>
            <div class="login">
                    <p class="message-request">Đăng nhập vào tài khoản!</p>
                    <div class="login-with-google">
                        <a class="btn login-google" href="">
                            <img src="../public/image/google-logo.png" alt="">
                            <span>Login with Google</span>
                        </a>
                    </div>
            </div>
    </div>
</div> -->
<?php 
    include_once BASE_URL."partials/footer.php";

?>
    <!-- <script src=">public/js/register.js"></script> -->


<script type="module">
    import { isValidName, removeDuplicateSpaceAndTrim, handleUpperCaseFirstLetter } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        const formRegister = $('#form-register')

        formRegister.submit(function(e) {
            e.preventDefault();
            const email = $('#input-email').val()
            let givenName = $('#input-given-name').val()
            let familyName = $('#input-family-name').val()

            // Xoa cac khoang trang thua, in hoa chu cai dau tien

            givenName = removeDuplicateSpaceAndTrim(givenName)
            givenName = handleUpperCaseFirstLetter(givenName)
            $('#input-given-name').val(givenName)

            familyName = removeDuplicateSpaceAndTrim(familyName)
            familyName = handleUpperCaseFirstLetter(familyName)
            $('#input-family-name').val(familyName)

            if (isValidName(givenName) && isValidName(familyName) && isValidName(givenName)) {
                handleRegister({email, familyName, givenName})
            }
            else {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Họ tên không hợp lệ!',
                        message: `Vui lòng không nhập các kí tự đặc biệt!`
                    })
                })
            }

        })
    })
   
    function handleRegister(info) {
        const {email, familyName, givenName} = info
        console.log(email, familyName, givenName)
        $.ajax({
            url: '<?=BASE_URL?>api/customer/authen.php',
            type: 'post',
            data: {
                action: 'register',
                email: email,
                familyName: familyName,
                givenName: givenName
            },
            beforeSend: function() {
                $('form .loading').addClass('show')
            },
            dataType: 'json',
            success: function(result) {
                $('form .loading').removeClass('show')
                console.log(result)
                if (result) {
                    handleMessage(function() {
                        showMessage({
                            type: 'success',
                            title: 'Thành công!',
                            message: `Bạn đã đăng ký tài khoản thành công! <br>Thông tin tài khoản đã gửi đến <strong><em>${email}</em></strong>`
                        })
                    })
                } 
                else {
                    handleMessage(function() {
                        showMessage({
                            type: 'error',
                            title: 'Thất bại!',
                            message: `Email <strong><em>${email}</em></strong> đã được đăng ký rồi!`
                        })
                    })
                }
            }
        })
    }
    
</script>