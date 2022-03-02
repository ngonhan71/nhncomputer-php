$(document).ready(function() {
    $('#input-token').hide()
    $('#form-send-email').submit(function(e) {
        e.preventDefault();
        const email = $('#input-email').val()
        alert(email)
        $('#input-token').show()

        // $('#form-send-email').submit(function(e) {
        $('.register-input-email ').hide()
        $('.register-customer-info').show();
        // })
        // ajax gửi email
        // susscess: function() {
            // if true: lấy dc token
            // Show input nhập token
        // kiểm tra token nhập vào
            // if true:
                // chuyển sang register bước 2: 
                // -> nhập họ tên, mật khẩu, confirm, tỉnh, address
        // }
    })
})

// php
// Nhận email -> tạo token -> lưu vào session, gửi đến email
// -> return result: true kèm theo token