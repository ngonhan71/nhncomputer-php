<?php 
    $isHomePage = true;
    include_once "./partials/header.php";

?>
    <div class="main">
        <div class="home-banner">
            <div class="container">
                <div class="row">
                    <div class="col col-xl-2">
                        <div class="header-menu">
<?php

        // include_once "database/dbhelper.php";
        // include_once "utility/utility.php";
        echo $resultMenu;
?>
                        </div>
                    </div>
                    <div class="col col-xl-7">
                        <div class="row column">
                            <div class="col col-xl-12">
                                <div class="slider">
                                    <div class="dots">
                                        <ul>
                                            <li class="dot"></li>
                                            <li class="dot"></li>
                                            <li class="dot"></li>
                                            <li class="dot"></li>
                                            <li class="dot"></li>
                                        </ul>
                                    </div>
                                <div class="slide-item">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/slideshow_14.jpg?v=23296" alt="">
                                </div>
                                <div class="slide-item">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/slideshow_3.jpg?v=23296" alt="">
                                </div>
                                <div class="slide-item">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/slideshow_11.jpg?v=23296" alt="">
                                </div>
                                <div class="slide-item">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/slideshow_12.jpg?v=23307" alt="">
                                </div>
                                <div class="slide-item">
                                        <img src="https://hanoicomputercdn.com/media/banner/01_Decc6ef5979b85c2db3ba8c211780c60c9f.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-12 bottom">
                                <div class="row">
                                    <div class="col col-xl-6">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/solid4.jpg?v=23296" alt="">
                                    </div>
                                    <div class="col col-xl-6">
                                        <img src="https://theme.hstatic.net/1000026716/1000440777/14/solid5.jpg?v=23296" alt="">
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="col col-xl-3" style="margin: auto 0;">
                        <div class="banner-right">
                            <img src="https://theme.hstatic.net/1000026716/1000440777/14/solid1.jpg?v=23296" alt="">
                            <img src="https://theme.hstatic.net/1000026716/1000440777/14/solid2.jpg?v=23296" alt="">
                            <img src="https://theme.hstatic.net/1000026716/1000440777/14/solid3.jpg?v=23296" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="homepage-product homepage-laptop">
        <div class="container">
            <div class="homepage-product__header" style="margin-bottom: 20px;">
                <div class="row">
                    <h2 class="header-title">Laptop, máy tính xách tay</h2>
                    <ul class="header-sub-category">
                        <li><a href="./laptop.php?brand=dell">Laptop Dell</a></li>
                        <div class="homepage-product-separator"></div>
                        <li><a href="./laptop.php?brand=hp">Laptop HP</a></li>
                        <div class="homepage-product-separator"></div>
                        <li><a href="./laptop.php?brand=lenovo">Laptop Lenovo</a></li>
                        <div class="homepage-product-separator"></div>
                        <li><a href="./laptop.php?brand=msi">Laptop MSI</a></li>
                    </ul>
                    <div class="show-all">
                        <a href="./laptop.php">Xem tất cả</a>
                    </div>
                </div>
            </div>
        
            <div class="homepage-product__body">
                <div class="row">
<?php
    $sqlGetLaptop = " select * from product, laptop_specification
                        where product_type = 1
                        and laptop_specification.product_id = product.product_id
                        limit 0, 10";
    $dataLaptop =  executeGetData($sqlGetLaptop);
    if (count($dataLaptop) > 0) {
        foreach ($dataLaptop as $key => $value) {
            echo '<div class="col col-xl-2-4 col-sm-6 col-6">
                    <div class="product-item">';
            if ($value['discount'] != 0) {
                echo ' <div class="box-discount">
                        <p>'.-$value['discount'].'%</p>
                    </div>';
            }
            echo          '<a title="'.$value['name'].'" href="'.BASE_URL.'san-pham.php?slug='.$value['slug'].'" data-id="'.$value['product_id'].'" class="product-img">
                            <img src="'.$value['thumbnail'].'" alt="">
                        </a>
                        <div class="product-info">
                            <a title="'.$value['name'].'" href="'.BASE_URL.'san-pham.php?slug='.$value['slug'].'">
                                <h3 class="product-name">LAPTOP '.$value['name'].' ('.$value['cpu'].'/'.$value['ram'].'GB RAM/'.$value['hard_drive_size'].'/'.$value['screen'].')
                                </h3>
                            </a>';
            if ($value['discount'] != 0) {
                $priceDiscount = $value['price'] - $value['price']* ($value['discount'])/100;
                echo '<div class="discount-info">
                        <span class="old-price">'.number_format($value['price'], 0, ',', '.').'đ</span>
                        <span class="discount">( Tiết kiệm: '.$value['discount'].'% )</span>
                    </div>
                    <p class="price">'.number_format(round($priceDiscount, - 4), 0, ',', '.').'đ</p>';
            }        
            else echo ' <div class="discount-info">
                            <span class="old-price">'.$value['price'].'</span>
                            <span class="discount"></span>
                        </div>
                        <p class="price">'.number_format($value['price'], 0, ',', '.').'đ</p>';
            if ($value['status'] == 1) {
                $addToCart = "'".$value['product_id']."', 1, '".$value['product_type']."'";
                echo                '<div class="action">
                                        <p class="available"><i class="fa fa-check"></i> Còn hàng</p>
                                        <p class="cart" onclick="addToCart('.$addToCart.')"><i class="bi bi-cart3"></i></p>
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
    }
?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Laptop Gaming -->
        <div class="homepage-product homepage-laptop-gaming">
        <div class="container">
         <div class="homepage-product__header" style="margin-bottom: 20px;">
             <div class="row">
                 <h2 class="header-title">Laptop gaming</h2>
                 <div class="show-all">
                     <a href="./laptop.php?q=laptop-gaming">Xem tất cả</a>
                 </div>
             </div>
         </div>
        
         <div class="homepage-product__body">
             <div class="row">
<?php
    $sqlLaptopGaming = "  select * from product, laptop_specification
                            where product_type = 1 and category_id = 4
                            and laptop_specification.product_id = product.product_id";
    $dataLaptopGaming =  executeGetData($sqlLaptopGaming);
    
    if (count($dataLaptopGaming) > 0) {
        foreach ($dataLaptopGaming as $key => $value) {
            echo '<div class="col col-xl-2-4 col-sm-6 col-6">
                    <div class="product-item">
                        <a href="'.BASE_URL.'san-pham.php?slug='.$value['slug'].'" data-id="'.$value['product_id'].'" class="product-img">
                            <img src="'.$value['thumbnail'].'" alt="">
                        </a>
                        <div class="product-info">
                            <a class="product-name">LAPTOP '.$value['name'].' ('.$value['cpu'].'/'.$value['ram'].'GB RAM/'.$value['hard_drive_size'].'/'.$value['screen'].')</a>';
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
                $addToCart = "'".$value['product_id']."', 1, '".$value['product_type']."'";
                echo                '<div class="action">
                                        <p class="available"><i class="fa fa-check"></i> Còn hàng</p>
                                        <p class="cart" onclick="addToCart('.$addToCart.')"><i class="bi bi-cart3"></i></p>
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
    }
?>
               
             </div>
         </div>
        </div>
     </div>
        <!-- close div main -->
    </div> 
 <?php
    include_once "./partials/footer.php";
 ?>

<script src="<?=BASE_URL?>public/js/header.js"></script>
<script src="<?=BASE_URL?>public/js/homepageSlider.js"></script>
<script src="<?=BASE_URL?>public/js/homepage-laptop.js"></script>

<script>
    function addToCart(productId, quantity, productType) {
        $.ajax({
            url: '<?=BASE_URL?>api/product/product.php',
            type: 'post',
            data: {
                action: 'add-to-cart',
                id: productId,
                quantity: quantity,
                productType: productType
            },
            dataType: 'json',
            success: function(result) {
                $('.cart-count-product').text(result.length)
                handleMessage(function() {
                    showMessage({
                        type: 'success',
                        title: 'Thành công!',
                        message: 'Thêm sản phẩm vào giỏ hàng thành công!'
                    })
                })
            }
        })
    }
</script>
