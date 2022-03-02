<?php 
    define('BASE_URL', './');
    include_once BASE_URL."partials/header.php";

?>
<?php

    if (isset($_SESSION['email'])) {
        $emailCustomer = $_SESSION['email'];
        $sqlGetCustomer = "select * from customer where email = ?";
        $customer = executeGetDataBindParam($sqlGetCustomer, "s", [$emailCustomer]);
        echo '<pre>';
        $customerInfo = $customer[0];
        var_dump($customerInfo);
        echo '/<pre>';
    }

?>
<script>
    $(document).ready(function() {
        handleMessage(function() {
            showMessage({
                type: 'error',
                title: 'Chưa hỗ trợ!',
                message: 'Tính năng này chưa sẵn sàng!'
            })
        })
    })
</script>