<?php
    if (!empty($_GET['q'])) {
        $keyword = $_GET['q'];
        $isCategoryPage = true;
        $titlePage = $keyword.' - Kết quả tìm kiếm| NHN Computer';
        include_once "partials/header.php";
        
        // $keywordArray = explode(' ', $keyword);
        // var_dump($keywordArray);
        // XSS
        $keyword = strip_tags($keyword);
        $paramSearch = "%" . $keyword . "%";
        $sqlSearch = "  select * from product
                        where product.name like ?
                        or product.product_type like ?";
        $dataSearch = executeGetDataBindParam($sqlSearch, "ss", [$paramSearch, $paramSearch]);
        // var_dump($dataSearch);
    }
    else {
        header("Location: ./index.php");
    }
?>

<div class="main">
    <div class="category-page">
        <div class="category-page-top">
            <div class="container">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?=BASE_URL?>index.php">Trang chủ </a>
                        </li>
                        <li>
                            <a href="">Tìm kiếm</a>
                        </li>'
                    </ul>
                </div>
                <?php
                    $heading = 'Từ khóa: ';
                    if (!empty($keyword)) { 
                        $heading .= $keyword;
                    }
                    echo '<h1 class="heading">'.$heading.'</h1>';
               ?>
                
            </div>
        </div>
        <div class="category-content">
            <div class="container">
                <div class="product-list">
                    <div class="row">
                        <?php
                            foreach ($dataSearch as $key => $value) {
                                $productType = $value['product_type'];
                                if ($productType == 1) {
                                    $sqlGetProductInfo = "  select * from laptop_specification
                                                            where laptop_specification.product_id = ?";
                                }
                                $productInfo = executeGetDataBindParam($sqlGetProductInfo, 's', [$value['product_id']]);
                                $productInfo = $productInfo[0];
                                echo '<div class="col col-xl-2-4">
                                        <div class="product-item">
                                            <a href="./san-pham.php?slug='.$value['slug'].'" class="product-img">
                                                <img src="'.$value['thumbnail'].'" alt="">
                                            </a>
                                            <div class="product-info">';
                                if ($productType == 1) {
                                    echo '<a href="./san-pham.php?slug='.$value['slug'].'" class="product-name">LAPTOP '.$value['name'].' ('.$productInfo['cpu'].'/'.$productInfo['ram'].'GB RAM/'.$productInfo['hard_drive_size'].'/'.$productInfo['screen'].')</a>';
                                }
                                                
                                    echo '<div class="discount-info">';
                                if ($value['discount'] != 0) {
                                    $priceDiscount = $value['price'] - $value['price'] * ($value['discount'])/100;
                                    echo '<span class="old-price">'.number_format($value['price'], 0, ',', '.').'đ</span>
                                            <span class="discount">( Tiết kiệm: '.$value['discount'].'% )</span>
                                        </div>
                                        <p class="price">'.number_format(round($priceDiscount, - 4), 0, ',', '.').'đ</p>';
                                }    
                                else echo '     <span class="old-price"></span>
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

    </div>
</div>
 
 <?php
    include_once "partials/footer.php";
 ?>
