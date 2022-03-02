<?php 
    define('BASE_URL', '../');
    $isRegisterPage = true;
    include_once BASE_URL."partials/header.php";
   
   
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
    // Google Client API

    // if (isset($_GET['code'])) {
    //     $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
    //     if(!isset($token["error"])){
    //         $googleClient->setAccessToken($token);
    //         $_SESSION['access_token'] = $googleClient->getAccessToken();

    //     }
    //     else{
    //         echo("<script>location.href = '../index.php';</script>");
    //     }

    // }

    // $authUrl = '';
    // if (!empty($_SESSION['access_token'])) {
    //     $googleClient->setAccessToken($_SESSION['access_token']);
    //     //get profile
    //     $googleServiceOauth2 = new Google_Service_Oauth2($googleClient);
    //     $googleAccountInfo = $googleServiceOauth2->userinfo->get();

    //     $googleAccountId = $googleAccountInfo['id'];
    //     $googleAccountEmail = $googleAccountInfo['email'];
    //     $googleAccountGivenName = $googleAccountInfo['givenName'];
    //     $googleAccountFamilyName = $googleAccountInfo['familyName'];
    //     $googleAccountAvatar = $googleAccountInfo['picture'];
    //     $_SESSION['email'] = $googleAccountEmail;
        
    //     $sql = "select * from customer where customer_id = ?";
    //     $data = executeGetDataBindParam($sql, "s", [$googleAccountId]);
    //     if (count($data) > 0) {
    //         // echo 'Da ton tai';
    //     }
    //     else {
    //         $sqlInsert = "insert into customer values (?, ?, ?, ?, ?)";
    //         $param = [$googleAccountId, $googleAccountEmail, $googleAccountGivenName, $googleAccountFamilyName, $googleAccountAvatar];
    //         $isSuccess = executeSqlBindParam($sqlInsert, "sssss", $param);
    //     }
    //     echo("<script>location.href = '../index.php';</script>");
 
    // }
    // else {
    //     $authUrl = $googleClient->createAuthUrl();

    // }

    // if ($googleClient->isAccessTokenExpired()) {
    //     $authUrl = $googleClient->createAuthUrl();

    // }

?>


<div class="main">
    <div class="auth">
        <div class="container">
            <h1 class="auth-heading">Đăng nhập</h1>
            <div class="login">
                <form id="form-login" action="" method="POST">
                    <p class="message-request">Đăng nhập vào tài khoản!</p>
                    <div class="form-group">
                        <label for="input-email" class="auth-icons fas fa-envelope"></label>
                        <input required id="input-email" type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group" id="form-group-password">
                        <label for="input-fullname" class="auth-icons fas fa-lock"></label>
                        <input required id="input-password" type="password" class="form-control" placeholder="Mật khẩu">
                    </div> 
                    <a href="" class="forgot-password">Quên mật khẩu?</a>
                    <button class="btn btn-submit-login" type="submit">Đăng nhập</button>
                    <div class="loading">
                            <img src="<?=BASE_URL?>public/image/loading-2.gif" alt="">
                    </div>
                </form>
                <div class="action">
                    <span>Bạn chưa có tài khoản? </span><a class="link-register" href="./register.php">Đăng ký tại đây</a>
                </div>
            </div>
    </div>
</div>

<?php 
    include_once BASE_URL."./partials/footer.php";

?>


<script type="module">
    import { isValidName, removeDuplicateSpaceAndTrim, handleUpperCaseFirstLetter } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        const formLogin = $('#form-login')

        formLogin.submit(function(e) {
            e.preventDefault();
            const email = $('#input-email').val()
            const password = $('#input-password').val()

            handleLogin(email, password)
        })
    })
   
    function handleLogin(email, password) {
        $.ajax({
            url: '<?=BASE_URL?>api/customer/authen.php',
            type: 'post',
            data: {
                action: 'login',
                email: email,
                password: password
            },
            beforeSend: function() {
                $('form .loading').addClass('show')
            },
            dataType: 'json',
            success: function(result) {
                $('form .loading').removeClass('show')
                console.log(result)
                if (result) {
                    location.href = '../index.php'
                } 
                else {
                    handleMessage(function() {
                        showMessage({
                            type: 'error',
                            title: 'Thất bại!',
                            message: `Email hoặc mật khẩu không chính xác!`
                        })
                    })
                }
            }
        })
    }
    
</script>