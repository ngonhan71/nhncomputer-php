<?php 
    include_once "./database/dbhelper.php";
    $isProductDetailPage = true;
    if (isset($_GET['product_id'])) {
        $productId = $_GET['product_id'];
        $sqlGetProduct = "select product_type, category_id, brand from product where product_id = ?";

        $product = execute_sql_get_data_bind_param($sqlGetProduct, 's', [$productId]);
        if (count($product) > 0) {
            $productType =  $product[0]['product_type'];
            $productBrand = $product[0]['brand'];
            $category = $product[0]['category_id'];
            if ($productType == 1) {
                $sqlProductDetail = "select product.*, laptop_specification.*, brand.name as brand_name from product, laptop_specification, brand
                        where product.product_id = ?
                        and laptop_specification.product_id = product.product_id
                        and product.brand = brand.id";
                    }
            $productInfo = execute_sql_get_data_bind_param($sqlProductDetail, 's', [$productId]);
            $productInfo = $productInfo[0];
            $titlePage = ''.$productInfo['name'].' | NHN Computer';
            include_once "partials/header.php";
        }
        else {
            header("Location: ./index.php");
        }
        
    }
    else {
        header("Location: ./index.php");
    }
    

?>
    <div class="breadcrumb">
        <div class="container">
            <p class="breadcrumb-content">Trang chủ -> <?=$productInfo['name']?></p>
        </div>
    </div>

    <div class="product-detail">
        <div class="product-detail-top">
            <div class="container">
                <div class="product-detail-header">
                    <h1 class="title">
                        <?php
                            if ($productType == 1) {
                                echo 'Laptop '.$productInfo['name'].' ('.$productInfo['cpu'].'/'.$productInfo['ram'].'GB RAM/'.$productInfo['hard_drive_size'].'/'.$productInfo['screen'].')';
                            }
                        ?>
                    </h1>
                </div>
                <div class="product-detail-content">
                    <div class="row">
                        <div class="col col-xl-4">
                            <div class="product-detail-img">
                                <div class="img-large">
                                    <img src="<?=$productInfo['thumbnail']?>" alt="">
                                </div>
                                <div class="img-list">
                                    <ul>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_5.jpg" alt=""></li>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_4.jpg" alt=""></li>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_3.jpg" alt=""></li>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_7.jpg" alt=""></li>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_7.jpg" alt=""></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-5">
                            <div class="product-detail-info">
                                <div class="product-detail-meta">
                                    <p class="product_detail-sku">Mã SP: <?=$productInfo['product_id']?></p>
                                </div>
                                <div class="product-detail-specification">
                                    <p class="title">Thông số sản phẩm</p>
                                    <ul class="product-summry">
                                        <?php
                                             if ($productType == 1) {
                                                echo '  <li>- CPU:'.$productInfo['cpu'].' '.$productInfo['cpu_detail'].']</li>
                                                        <li>- RAM: '.$productInfo['ram'].'GB</li>
                                                        <li>- Ổ cứng: '.$productInfo['hard_drive_size'].'</li>
                                                        <li>- VGA: '.$productInfo['graphics'].'</li>
                                                        <li>- Màn hình: '.$productInfo['screen'].'</li>';
                                            }
                                        ?>
                                    </ul>
                                    <button class="btn view-product-detail">Xem thêm cấu hình chi tiết</button>
                                </div>
                                <div class="product-detail-price">
                                <?php
                                    if ($productInfo['discount'] != 0) {
                                        $dicount = $productInfo['price']* ($productInfo['discount'])/100;
                                        $price_discount = $productInfo['price'] - $dicount;
                                        echo '  <p class="p-discount">'.number_format(round($price_discount, - 4), 0, ',', '.').'đ</p>
                                                <p class="price">'.number_format($productInfo['price'], 0, ',', '.').'đ</p>
                                                <p class="discount">Tiết kiệm: '.number_format($dicount, 0, ',', '.').'đ</p>';
                                    }    
                                    else { 
                                        echo '<p class="p-discount">'.number_format($productInfo['price'], 0, ',', '.').'đ</p>';
                                    }
                                ?>
                                </div>
                                <div class="product-detail-box-quantity">
                                    <span>Số lượng: </span>
                                    <div class="box-quanity-select">
                                        <button class="sub btn-quantity-change">-</button>
                                        <input class="input-quantity" value="1" size="5">
                                        <button class="add btn-quantity-change">+</button>
                                    </div>
                                    <button class="btn-add-to-cart"><i class="bi bi-cart-check"></i> Thêm vào giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-product-detail">
        <div class="modal-content">
            <div class="modal-header">
                <h3><?=$productInfo['name']?></h3>
                <button class="btn-close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <table>
                    <thead>
                        <tr>
                            <td>Mô tả chi tiết</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hãng sản xuất</td>
                            <td><?=$productInfo['brand_name']?></td>
                        </tr>
<?php
    if ($productType == 1) {
        echo '<tr>
                <td>Bộ vi xử lý</td>
                <td>'.$productInfo['cpu'].' '.$productInfo['cpu_detail'].'</td>
            </tr>
            <tr>
                <td>Bộ nhớ trong</td>
                <td>'.$productInfo['ram'].' GB</td>
            </tr>
            <tr>
                <td>VGA</td>
                <td>'.$productInfo['graphics'].'</td>
            </tr>
            <tr>
                <td>Ổ cứng</td>
                <td>'.$productInfo['hard_drive_size'].' '.$productInfo['hard_drive_desc'].'</td>
            </tr>
            <tr>
                <td>Màn hình</td>
                <td>'.$productInfo['screen'].'</td>
            </tr>
            <tr>
                <td>Khối lượng</td>
                <td>'.$productInfo['weight'].' kg</td>
            </tr>';
    }
?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    <div class="related-product">
        <div class="container">
         <div class="related-product-header">
                <h2 class="header-title">Sản phẩm tương tự</h2>
         </div>
         <div class="related-product-body">
             <button class="carousel-btn carousel-pre"><i class="fas fa-chevron-left"></i></button>
             <button class="carousel-btn carousel-next"><i class="fas fa-chevron-right"></i></button>
             <div class="row">
<?php

    $sqlRelatedProduct = "  select * from product, laptop_specification
                            where product.product_type = 1 and (product.category_id = '".$category."' or brand = '".$productBrand."')
                            and laptop_specification.product_id = product.product_id
                            limit 0,8";
    $productRelated = execute_sql_get_data($sqlRelatedProduct);
    foreach ($productRelated as $key => $value) {
        echo '<div class="col col-xl-2-4">
                    <div class="product-item">
                        <a href="'.BASE_URL.'product.php?product_id='.$value['product_id'].'" data-id="'.$value['product_id'].'" class="product-img">
                            <img src="'.$value['thumbnail'].'" alt="">
                        </a>
                        <div class="product-info">
                            <a href="'.BASE_URL.'product.php?product_id='.$value['product_id'].'" class="product-name">LAPTOP '.$value['name'].' ('.$value['cpu'].'/'.$value['ram'].'GB RAM/'.$value['hard_drive_size'].'/'.$value['screen'].')</a>';
            if ($value['discount'] != 0) {
                $price_discount = $value['price'] - $value['price']* ($value['discount'])/100;
                echo '<div class="discount-info">
                        <span class="old-price">'.number_format($value['price'], 0, ',', '.').'đ</span>
                        <span class="discount">( Tiết kiệm: '.$value['discount'].'% )</span>
                    </div>
                    <p class="price">'.number_format(round($price_discount, - 4), 0, ',', '.').'đ</p>';
            }        
            else echo ' <div class="discount-info">
                            <span class="old-price"></span>
                            <span class="discount"></span>
                        </div>
                        <p class="price">'.number_format($value['price'], 0, ',', '.').'đ</p>';
            if ($value['status'] == 1) {
                echo                '<div class="action">
                                        <p class="available"><i class="fa fa-check"></i> Còn hàng</p>
                                        <p class="cart"><i class="bi bi-cart3"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            else {
                echo            '<div class="action">
                                        <p class="sold-out"><i class="bi bi-telephone-fill"></i> Liên hệ</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
    }
?>
                
             </div>
         </div>
        </div>
     </div>
<?php
    include_once "partials/footer.php";
 ?>
<script>
    $(document).ready(function() {
        let currentSlide = 0;

        const imgDisplay = $('.product-detail-img .img-large img')
        const RelatedProducts = $('.related-product-body .col')
        const countRelatedProduct = RelatedProducts.length
        $('.product-detail-img .img-item').click(function(e) {
            $.each($('.product-detail-img .img-item'), function(index, item) {
            $(this).removeClass('active')
            })
            $(this).addClass('active')
            imgDisplay.attr('src', e.target.src) 
        })

        $('.btn.view-product-detail').click(function() {
            $('.modal-product-detail').css({"visibility": "visible", "opacity": "1"});
        })
        $('.modal-product-detail .btn-close').click(function() {
            $('.modal-product-detail').css({"visibility": "hidden", "opacity": "0"});
        })

        $('.modal-product-detail').click(function() {
            $('.modal-product-detail').css({"visibility": "hidden", "opacity": "0"});
        })

        $('.modal-product-detail .modal-content').click(function(e) {
            e.stopPropagation();
        })

        $('.carousel-btn.carousel-next').click(function() {
            if (currentSlide < (countRelatedProduct - 5)) {
                ++currentSlide;
                let transform = currentSlide * (-100);
                $.each(RelatedProducts, function(index, item) {
                    $(this).css('transform', `translateX(${transform}%)`)
                })
                $('.carousel-btn.carousel-pre').prop('disabled', false)
            }
            else {
                $('.carousel-btn.carousel-next').prop('disabled', true)
            }
            console.log(currentSlide)
        })
        $('.carousel-btn.carousel-pre').click(function() {
            if (currentSlide > 0 ) {
                --currentSlide;
                let transform = currentSlide * (-100);
                $.each(RelatedProducts, function(index, item) {
                    $(this).css('transform', `translateX(${transform}%)`)
                })
                $('.carousel-btn.carousel-next').prop('disabled', false)
            }
            else {
                $('.carousel-btn.carousel-pre').prop('disabled', true)
            }
        })
    })
</script>