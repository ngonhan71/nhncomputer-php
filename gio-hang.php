<?php 
    $isCartPage = true;
    
    include_once "partials/header.php";

    
?>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li>
                        <a href="<?=BASE_URL?>index.php">Trang chủ </a>
                    </li>
                    <li>
                        <a href="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php

    if ($count <= 0) {
        echo '<div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="cart-empty">
                            <img src="https://www.hanoicomputer.vn/template/july_2021/images/tk-shopping-img.png" alt="">
                            <p>Không có sản phẩm nào trong giỏ hàng của bạn!</p>
                            <a href="./index.php" class="btn btn-back-home">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            </div>';
    }
    else {
?>

    <div class="cart step-1">
        <div class="container">
            <div class="row">
                <div class="col col-xl-9">
                    <div class="cart-content-left">
                        <table>
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Đơn giá</td>
                                    <td>Số lượng</td>
                                    <td>Thành tiền</td>
                                    <td>Chức năng</td>
                                </tr>
                            </thead>
                            <tbody class="cart-product-list">

                                <?php
    $totalCart = 0;
    $html = '';
    foreach ($cart as $key => $value) {
        $productId = $value['product_id'];
        if ($value['type'] == 1) {
            $sqlGetProductInfo = "  select product.*, laptop_specification.*, brand.name as brand_name from product, laptop_specification, brand
                                    where product.product_id = ?
                                    and laptop_specification.product_id = product.product_id
                                    and product.brand = brand.id";
        }
        $productInfo = executeGetDataBindParam($sqlGetProductInfo, 's', [$productId]);
        $productInfo = $productInfo[0];
        $itemPrice = $productInfo['price'];
        if ($productInfo['discount'] != 0) {
            $itemPrice = $productInfo['price'] - $productInfo['price'] * ($productInfo['discount'])/100;
            $itemPrice = round($itemPrice, -4);
        }
        $totalItemPrice = $itemPrice * $value['quantity'];
        $totalCart += $totalItemPrice;
        $html .= '<div class="item">
                    <span class="count">'.$value['quantity'].'x</span>
                    <span>'.$productInfo['name'].'</span>
                    <span>'.number_format($itemPrice, 0, ',', '.').'đ</span>
                </div>';
        echo '<tr>
                <td>
                    <a href="./san-pham.php?slug='.$productInfo['slug'].'">
                    <div class="cart-product">
                        <div class="row">
                                <div class="col col-xl-4">
                                    <img src="'.$productInfo['thumbnail'].'" alt="">
                                </div>
                                <div class="col col-xl-8">
                                    <div class="product-info">
                                        <p>'.$productInfo['name'].' ('.$productInfo['cpu'].'/'.$productInfo['ram'].'GB RAM/'.$productInfo['hard_drive_size'].'/'.$productInfo['screen'].')</p>
                                        <p>Mã SP: <b>'.$productId.'</b></p>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </a>
                </td>
                <td>'.number_format($itemPrice, 0, ',', '.').'đ</td>
                <td>
                    <div class="item-quanity">
                        <div class="product-detail-box-quantity">
                            <div class="box-quanity-select">
                                <button class="sub btn-quantity-change">-</button>
                                <input data-id="'.$productId.'" type="number" class="input-quantity" min="1" step="1" value="'.$value['quantity'].'" size="5">
                                <button class="add btn-quantity-change">+</button>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="total-item-price">'.number_format($totalItemPrice, 0, ',', '.').'đ</p>
                </td>
                <th>
                    <button class="btn-delete-from-cart" data-id="'.$productId.'"  id="button_'.$productId.'" data-price="'.$itemPrice.'" data-total="'.$totalItemPrice.'">
                        <i class="bi bi-x-lg"></i>  
                    </button>
                </th>
            </tr>';
    }

?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col col-xl-3">
                    <div class="cart-content-right">
                        <div class="box-cart-voucher">
                            <div class="voucher-group">
                                <input type="text" placeholder="Mã giảm giá">
                                <button class="btn btn-apply-discount-code">Áp dụng</button>
                            </div>
                        </div>
                        <div class="box-cart-total-price">
                            <div class="row">
                                <p>Tạm tính</p>
                                <p class="total-cart-price"><?=number_format($totalCart, 0, ',', '.')?>đ</p>
                            </div>
                            <div class="row">
                                <p>Giảm giá</p>
                                <p class="price-discount">0₫</p>
                            </div>
                            <div class="row">
                                <p>Thành tiền</p>
                                <p class="color-red total-cart-payment"><?=number_format($totalCart, 0, ',', '.')?>đ</p>
                            </div>
                        </div>
                        <button class="btn btn-buy-submit-cart">Tiến hành đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart step-2">
        <div class="container">
            <div class="row">
                <div class="col col-xl-8">
                    <div class="cart-content-left">
                        <h4>2. Địa chỉ giao hàng</h4>
                        <div class="box-address">
                            <div class="box-address-item">
                                <label for="">Họ tên</label>
                                <input type="text" id="buyer_name" class="input-text" placeholder="Họ và tên">
                            </div>
                            <div class="box-address-item">
                                <label for="">Số điện thoại</label>
                                <input type="text" id="buyer_mobile" class="input-text" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="box-address-item">
                                <label for="">Email</label>
                                <input type="text" id="buyer_email" class="input-text" placeholder="Nhập email">
                            </div>
                            <div class="box-address-item">
                                <label for="">Tỉnh/Thành phố</label>
                                <select name="" id="buyer_province">
                                    <option value="">Bến Tre</option>
                                </select>
                            </div>
                            <div class="box-address-item">
                                <label for="">Quận/Huyện</label>
                                <select name="" id="buyer_district">
                                    <option value="">Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="box-address-item">
                                <label for="">Phường/Xã</label>
                                <select name="" id="buyer_ward">
                                    <option value="">Phường/Xã</option>
                                </select>
                            </div>
                            <div class="box-address-item">
                                <label for="">Địa chỉ</label>
                                <input type="text" id="buyer_address" class="input-text" placeholder="Số nhà, tên đường">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-4">
                    <div class="cart-content-right">
                        <div class="cart-info">
                            <p class="total-count"><?=$count?> sản phẩm</p>
                            <div class="product-list">
                                <?php
                                   echo $html;
                                ?>
                            </div>
                            <div class="total-cart-price row">
                                <span>Thành tiền</span>
                                <span class="total-cart-payment"><?=number_format($totalCart, 0, ',', '.')?>đ</span>
                            </div>
                        </div>
                        <div class="box-pay-method">
                            <h4>Chọn hình thức thanh toán</h4>
                            <div class="pay-method-item">
                                <label for="pay-method1">
                                    <input type="radio" checked name="pay_method" class="input-radio" id="pay-method1">
                                    <span class="txt">Thanh toán qua chuyển khoản qua tài khoản ngân hàng (khuyên dùng)</span>
                                </label>
                            </div>
                           <div class="pay-method-item">
                            <label for="pay-method2">
                                    <input type="radio" name="pay_method" class="input-radio" id="pay-method2">
                                    <span class="txt">Thanh toán khi nhận hàng</span>
                                </label>
                           </div>
                            <button class="btn btn-buy-submit-cart">Tiến hành đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  } ?>
<?php
    include_once "partials/footer.php";
 ?>

<script type="module">
    import { isInteger } from '<?=BASE_URL?>public/js/validate.js';
    $(document).ready(function() {
        $('.add.btn-quantity-change').click(function(e) {
            const btnAddQuantity = $(this);
            const boxQuanity = btnAddQuantity.parent();
            const inputQuantity = boxQuanity.children(".input-quantity")
            let inputQuantityValue = inputQuantity.val()
            inputQuantity.val(++inputQuantityValue)

            updateQuantity(inputQuantity.data('id'), inputQuantity.val())

        })

        $('.sub.btn-quantity-change').click(function() {
            const btnAddQuantity = $(this);
            const boxQuanity = btnAddQuantity.parent();
            const inputQuantity = boxQuanity.children(".input-quantity")
            let inputQuantityValue = inputQuantity.val()

            if (inputQuantityValue == 1) {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Có lỗi !',
                        message: 'Số lượng không được nhỏ hơn 1 !'
                    })
                })
                return
            }
            inputQuantity.val(--inputQuantityValue)
            updateQuantity(inputQuantity.data('id'), inputQuantity.val())

        })

        $.each($('.btn-delete-from-cart'), function(index, button) {
            $(this).click(function(e) {
                // console.log($(this).data('id'))
                deleteItem($(this).data('id'))
            })
        })

        $.each($('.box-quanity-select .input-quantity'), function(index, input) {
            $(this).change(function() {
                const inputElement = $(this)
                const inputElementValue = inputElement.val()
                if (!isInteger(inputElementValue)) {
                    handleMessage(function() {
                        showMessage({
                            type: 'info',
                            title: 'Có lỗi !',
                            message: 'Số lượng phải là số nguyên!'
                        })
                    })
                    if (parseInt(inputElementValue) && inputElementValue >= 1) {
                        inputElement.val(parseInt(inputElementValue))
                    }
                    else {
                        inputElement.val(1)
                    }
                    updateQuantity(inputElement.data('id'), inputElement.val())
                    return
                }

                if (inputElement.val() < 1) {
                    console.log(inputElement.val())
                    handleMessage(function() {
                        showMessage({
                            type: 'info',
                            title: 'Có lỗi !',
                            message: 'Số lượng không được nhỏ hơn 1 !'
                        })
                    })
                    inputElement.val(1)
                }
                updateQuantity(inputElement.data('id'), inputElement.val())
            })
        })

        $('.btn-apply-discount-code').click(function() {
            handleMessage(function() {
                showMessage({
                    type: 'info',
                    title: 'Chưa hỗ trợ !',
                    message: 'Tính năng đang được xây dựng!'
                })
            })
        })

        $('.btn-buy-submit-cart').click(function() {
            $('.cart.step-1').hide();
            $('.cart.step-2').show();
        })


    })
    function deleteItem(productId) {
        $.ajax({
            url: '<?=BASE_URL?>api/product/product.php',
            type: 'post',
            data: {
                action: 'delete-from-cart',
                productId: productId,
            },
            dataType: 'json',
            success: function(result) {
                if (result.status = 'success') {
                    const buttonDelete = $('#button_' + productId)
                    const rowDelete = buttonDelete.parent().parent()

                    rowDelete.remove();
                    
                    handleUpdateTotalCart();
                    
                    $('.cart-count-product').text(result.data.length)
                    if (result.data.length == 0) {
                        let html = ` <div class="container">
                                        <div class="row">
                                            <div class="cart-empty">
                                                <img src="https://www.hanoicomputer.vn/template/july_2021/images/tk-shopping-img.png" alt="">
                                                <p>Không có sản phẩm nào trong giỏ hàng của bạn!</p>
                                                <a href="./index.php" class="btn btn-back-home">Tiếp tục mua sắm</a>
                                            </div>
                                        </div>
                                    </div>`
                        $('.cart').html(html)
                    }

                }
                
            }
        })
    }

    function updateQuantity(productId, newQuantity) {
        $.ajax({
            url: '<?=BASE_URL?>api/product/product.php',
            type: 'post',
            data: {
                action: 'update-quantity-item',
                productId: productId,
                quantity: newQuantity
            },
            dataType: 'json',
            success: function(result) {
                if (result.status = 'success') {
                    const buttonDelete = $('#button_' + productId)
                    const tr = buttonDelete.parent().parent();
                    const tdTotalItemPrice = tr.children("td").eq(3).children("p")

                    const itemPrice = buttonDelete.data('price')
                    const totalItemPrice = itemPrice * newQuantity;
                    const totalItemPriceFormat = new Intl.NumberFormat('de-DE').format(totalItemPrice)

                    tdTotalItemPrice.text(`${totalItemPriceFormat}đ`)
                    buttonDelete.data('total', totalItemPrice)
                    buttonDelete.attr('data-total', totalItemPrice)
                    handleUpdateTotalCart()
                }
            }
        })
    }

    function handleUpdateTotalCart() {
        let newTotalCartPrice = 0;
        $.each($('.btn-delete-from-cart'), function(index, button) {
            newTotalCartPrice += $(this).data('total')
        })
        
        const newTotalCartPriceFormat = new Intl.NumberFormat('de-DE').format(newTotalCartPrice)
        $('.total-cart-price').text(`${newTotalCartPriceFormat}đ`)

        $('.total-cart-payment').text(`${newTotalCartPriceFormat}đ`)

    }


    

</script>


<script type="module">
    import { loadProvince, loadDistrict, loadWard, firstLoad } from '<?=BASE_URL?>public/js/fetchAdress.js';

    $(document).ready(function() {


        firstLoad('buyer_province', 'buyer_district', 'buyer_ward');

        $('#buyer_province').change(async function() {
            const provinceId = $('#buyer_province').val()
            $('#buyer_ward').html('<option value="">Chọn phường/xã</option>')
            await loadDistrict('buyer_district', provinceId)
            const districtId = $('#buyer_district').val()
            await loadWard('buyer_ward', provinceId, districtId)
        })

        $('#buyer_district').change(async function() {
            const provinceId = $('#buyer_province').val()
            const districtId = $('#buyer_district').val()
            await loadWard('buyer_ward', provinceId, districtId)

        })
    })
</script>