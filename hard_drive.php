<?php 
    $isCategoryPage = true;
    include_once "partials/header.php";

    if (isset($_GET['type'])) {
        $slug = $_GET['type'];
        $sql_get_category = "select * from category where slug = '".$slug."'";
        $data_get_category = executeGetData($sql_get_category);
        $data_get_category = $data_get_category[0];
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
                            <a href="">Ổ cứng</a>
                        </li>
                        <?php
                                if (!empty($data_get_category)) { 
                                    echo '<li>
                                            <a href="">'.$data_get_category['name'].'</a>
                                        </li>';
                                }
                        ?>
                    </ul>
                </div>

                <?php
                    if (!empty($data_get_category)) { 
                        echo '<h1 class="heading">'.$data_get_category['name'].'</h1>';
                    }
                    else echo '<h1 class="heading">Ổ cứng</h1>';
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