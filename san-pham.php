<?php 
    include_once "./database/dbhelper.php";
    $isProductDetailPage = true;
    if (isset($_GET['slug'])) {
        $productSlug = $_GET['slug'];
        $sqlGetProduct = "select product_id, product_type, category_id, brand from product where slug = ?";

        $product = executeGetDataBindParam($sqlGetProduct, 's', [$productSlug]);
        if (count($product) > 0) {
            $productType =  $product[0]['product_type'];
            $productBrand = $product[0]['brand'];
            $category = $product[0]['category_id'];
            $productId = $product[0]['product_id'];
            if ($productType == 1) {
                $sqlProductDetail = "select product.*, laptop_specification.*, brand.name as brand_name from product, laptop_specification, brand
                        where product.product_id = ?
                        and laptop_specification.product_id = product.product_id
                        and product.brand = brand.id";
                    }
            $productInfo = executeGetDataBindParam($sqlProductDetail, 's', [$productId]);
            $productInfo = $productInfo[0];
            $titlePage = ''.$productInfo['name'].' | NHN Computer';
            
            //SEO
            $metaDescription = 'Mua Laptop '.$productInfo['name'] . ' giá rẻ cho sinh viên tại NHN Computer, nhiều khuyến mãi, hàng chính hãng';
            $metaKeywords = 'NHN COMPUTER - '.$productInfo['name'].', '.$productInfo['keywords'];
           
            $openGraph = true;
            $propertyTitle = $titlePage;
            $propertyDescription = $metaKeywords;
            $propertyUrl = 'http://nhncomputer.epizy.com/san-pham.php?slug='.$productSlug.'';
            $propertyImage = $productInfo['thumbnail'];
            $propertyImageAlt = $propertyTitle;

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
                        <div class="col col-xl-4 col-sm-12 col-12">
                            <div class="product-detail-img">
                                <div class="img-large">
                                    <img src="" title="<?=$productInfo['name']?>" alt="<?=$productInfo['name']?>">
                                </div>
                                <div class="img-list">
                                    <ul>
                                        <li class="img-item"><img title="<?=$productInfo['name']?>" src="<?=$productInfo['thumbnail']?>" alt="<?=$productInfo['name']?>"></li>
                                        <li class="img-item"><img src="https://hanoicomputercdn.com/media/product/61636_laptop_asus_vivobook_m3500qc_7.jpg" alt=""></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-5 col-sm-12 col-12">
                            <div class="product-detail-info">
                                <div class="product-detail-meta">
                                    <p class="product_detail-sku">Mã SP: <?=$productInfo['product_id']?></p>
                                </div>
                                <div class="product-detail-specification">
                                    <h2 class="title">Thông số sản phẩm</h2>
                                    <ul class="product-summry">
                                        <?php
                                             if ($productType == 1) {
                                                echo '  <li>- CPU: '.$productInfo['cpu'].' '.$productInfo['cpu_detail'].'</li>
                                                        <li>- RAM: '.$productInfo['ram'].'GB</li>
                                                        <li>- Ổ cứng: '.$productInfo['hard_drive_size'].'</li>
                                                        <li>- Card đồ họa: '.$productInfo['graphics'].'</li>
                                                        <li>- Màn hình: '.$productInfo['screen'].'</li>
                                                        <li>- Trọng lượng: '.$productInfo['weight'].'kg</li>';
                                            }
                                        ?>
                                    </ul>
                                    <button class="btn view-product-detail">Xem thêm cấu hình chi tiết</button>
                                </div>
                                <div class="product-detail-price">
                                <?php
                                    if ($productInfo['discount'] != 0) {
                                        $discount = $productInfo['price'] * ($productInfo['discount'])/100;
                                        $priceDiscount = $productInfo['price'] - $discount;
                                        echo '  <p class="p-discount">'.number_format(round($priceDiscount, - 4), 0, ',', '.').'đ</p>
                                                <p class="price">'.number_format($productInfo['price'], 0, ',', '.').'đ</p>
                                                <p class="discount">Tiết kiệm: '.number_format(round($discount, -4), 0, ',', '.').'đ</p>';
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
                                        <input type="number" step="1" min="1" class="input-quantity" value="1" size="5">
                                        <button class="add btn-quantity-change">+</button>
                                    </div>
                                    <button data-id="<?=$productInfo['product_id']?>" data-type="<?=$productType?>" class="btn-add-to-cart" id="btn-add-to-cart"><i class="bi bi-cart-check"></i> Thêm vào giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                $sqlGetReview = "select * from product_review where product_id = ?";
                $dataReview = executeGetDataBindParam($sqlGetReview, "s", [$productId]);
                if (count($dataReview) > 0) {
                    $productReview = $dataReview[0];
                }
                if (isset($productReview)) { ?>
                    <div class="review">
                            <div class="container">
                                <div class="review-content">
    <?php
                        echo $productReview['content'];
                   
    ?>
                                </div>
                            </div>
                        </div>
            <?php
              }
                ?>
      
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
             <div class="row slider">
<?php

    $sqlRelatedProduct = "  select * from product, laptop_specification
                            where product.product_type = 1 and (product.category_id = ? or brand = ?)
                            and laptop_specification.product_id = product.product_id
                            limit 0,8";
    $productRelated = executeGetDataBindParam($sqlRelatedProduct, "ii", [$category, $productBrand]);

    foreach ($productRelated as $key => $value) {
        echo '<div class="col col-xl-2-4 col-6 slide-item">
                    <div class="product-item">';
        if ($value['discount'] != 0) {
            echo ' <div class="box-discount">
                    <p>'.-$value['discount'].'%</p>
                </div>';
        }
        echo               '<a href="'.BASE_URL.'san-pham.php?slug='.$value['slug'].'" data-id="'.$value['product_id'].'" class="product-img">
                            <img src="'.$value['thumbnail'].'" alt="">
                        </a>
                        <div class="product-info">
                            <a href="'.BASE_URL.'san-pham.php?slug='.$value['slug'].'" class="product-name">LAPTOP '.$value['name'].' ('.$value['cpu'].'/'.$value['ram'].'GB RAM/'.$value['hard_drive_size'].'/'.$value['screen'].')</a>';
            if ($value['discount'] != 0) {
                $priceDiscount = $value['price'] - $value['price']* ($value['discount'])/100;
                echo '<div class="discount-info">
                        <span class="old-price">'.number_format($value['price'], 0, ',', '.').'đ</span>
                        <span class="discount">( Tiết kiệm: '.$value['discount'].'% )</span>
                    </div>
                    <p class="price">'.number_format(round($priceDiscount, - 4), 0, ',', '.').'đ</p>';
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

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<?php
    include_once "partials/footer.php";
 ?>
<script type="module">

    import { addToCart } from './public/js/cart.js';
    import { isInteger } from '<?=BASE_URL?>public/js/validate.js';

    $(document).ready(function() {

        $('.slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            infinite: false,
            prevArrow: $('.carousel-btn.carousel-pre'),
            nextArrow: $('.carousel-btn.carousel-next'),
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                    {
                    breakpoint: 414,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        let currentSlide = 0;

        const imgDisplay = $('.product-detail-img .img-large img')

        imgDisplay.attr('src', $('.product-detail-img .img-item').eq(0).children('img').attr('src'))
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


        const inputQuantity = $('.input-quantity')

        inputQuantity.change(function() {
            const inputElementValue = $(this).val()
            if (!isInteger(inputElementValue)) {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Có lỗi !',
                        message: 'Số lượng phải là số nguyên!'
                    })
                })
                if (parseInt(inputElementValue) && inputElementValue >= 1) {
                    $(this).val(parseInt(inputElementValue))
                }
                else {
                    $(this).val(1)
                }
                return

            }

            if ($(this).val() < 1) {
                handleMessage(function() {
                    showMessage({
                        type: 'info',
                        title: 'Có lỗi !',
                        message: 'Số lượng không được nhỏ hơn 1 !'
                    })
                })
                $(this).val(1)
            }
        })

        $('.add.btn-quantity-change').click(function() {
            let inputQuantityValue = inputQuantity.val();
            inputQuantity.val(++inputQuantityValue)
        })

        $('.sub.btn-quantity-change').click(function() {
            let inputQuantityValue = inputQuantity.val();

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
        })


        $('#btn-add-to-cart').click(function() {
            const productId = $(this).data('id')
            const productType = $(this).data('type')
            const quantity = $('.input-quantity').val()
            addToCart(productId, quantity, productType, './')

            handleMessage(function() {
                showMessage({
                    type: 'success',
                    title: 'Thành công!',
                    message: 'Thêm sản phẩm vào giỏ hàng thành công!'
                })
            })
        })

    })
    
</script>
