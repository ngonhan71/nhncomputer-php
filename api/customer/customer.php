<?php
    session_start();
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        define('BASE_URL', '../../');
        switch ($action) {
            case 'add-address':
                $address = $_POST['address'];
                addAddress($address);
                break;
            case 'delete-address':
                $id = $_POST['addressId'];
                deleteAddress($id);
                break;
            case 'change-password':
                $currentPassword = $_POST['currentPassword'];
                $newPassword = $_POST['newPassword'];
                $csrfToken = $_POST['csrfToken'];
                $customerId = $_POST['customerId'];
                updatePassword([
                    'currentPassword' => $currentPassword, 
                    'newPassword' => $newPassword, 
                    'csrfToken' => $csrfToken, 
                    'customerId' => $customerId, 
                ]);
                break;
        }
    }
   
    function addAddress($address) {
        include_once "../../database/dbhelper.php";

        $customerId = $_SESSION['customer_id'];

        $sql = "insert into address(customer_id, address) values(?, ?)";
        if (executeSqlBindParam($sql, "ss", [$customerId, $address])) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function deleteAddress($id) {
        include_once "../../database/dbhelper.php";

        $sql = "delete from address where id = ?";
        if (executeSqlBindParam($sql, "i", [$id])) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function updatePassword($input) {
        include_once "../../database/dbhelper.php";

        $csrfToken = $input['csrfToken'];

        if ($csrfToken == $_SESSION['csrf-token']) {
            $currentPassword = $input['currentPassword'];

            $sql = "select * from customer where customer_id = ? and password = ?";
            $verify = executeGetDataBindParam($sql, "ss", [$input['customerId'], md5($currentPassword)]);
    
            if (count($verify) > 0) { // mat khau hien tai dung
                $newPassword = $input['newPassword'];
                $hashPassword = md5($newPassword);
    
                $sqlUpdatePassword = "update customer set password = ? where customer_id = ?";
                $result = executeSqlBindParam($sqlUpdatePassword, "ss", [$hashPassword, $input['customerId']]);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'M???t kh???u hi???n t???i kh??ng ????ng!']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'B???n kh??ng c?? quy???n th???c hi???n h??nh ?????ng n??y!']);
        }
    }
 
?>
