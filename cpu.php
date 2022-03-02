<?php 
    $isCategoryPage = true;
    include_once "partials/header.php";

    if (isset($_GET['brand'])) {
        $slug = $_GET['brand'];
        $sqlGetCategory = "select * from category where slug = '".$slug."'";
        $dataGetCategory = executeGetData($sqlGetCategory);
        $dataGetCategory = $dataGetCategory[0];
    }

?>
<div class="main">
    <div class="category-page">
        <div class="container">
            <div class="category-page__header">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?=BASE_URL?>index.php">Trang chủ </a>
                        </li>
                        <li>
                            <a href="">CPU - Bộ vi xử lý</a>
                        </li>
                        <?php
                                if (!empty($dataGetCategory)) { 
                                    echo '<li>
                                            <a href="">'.$dataGetCategory['name'].'</a>
                                        </li>';
                                }
                        ?>
                    </ul>
                </div>

                <?php
                    if (!empty($dataGetCategory)) { 
                        echo '<h1 class="heading">'.$dataGetCategory['name'].'</h1>';
                    }
                    else echo '<h1 class="heading">CPU - Bộ vi xử lý</h1>';
               ?>
                
            </div>
        </div>
    </div>
</div>
 
 <?php
    include_once "partials/footer.php";
 ?>

<script src="<?=BASE_URL?>public/js/header.js"></script>
<script src="<?=BASE_URL?>public/js/homepage-slide.js"></script>
<script src="<?=BASE_URL?>public/js/homepage-laptop.js"></script>