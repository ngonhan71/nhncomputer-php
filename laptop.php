<?php 
    $isCategoryPage = true;
    $titlePage = 'Laptop, máy tính xách tay | NHN Computer';
    include_once "partials/header.php";

    if (isset($_GET['q'])) {
        $slug = $_GET['q'];
        $params = [$slug];
        $sqlGetCollection = "select * from category where slug = ?";
        $dataGetCollection = executeGetDataBindParam($sqlGetCollection, "s", $params);
        $dataGetCollection = $dataGetCollection[0];

     
        $categoryId = $dataGetCollection['id'];
        $sqlGetAllProduct = "select * from product, laptop_specification
                                where product_type = 1 and category_id = ?
                                and laptop_specification.product_id = product.product_id";
        $allProduct = executeGetDataBindParam($sqlGetAllProduct, "i", [$categoryId]);
    }

    if (isset($_GET['brand'])) {
        $brand = $_GET['brand'];
        $params = [$brand];
        $sqlGetBrand = "select * from brand where slug = ?";
        $dataGetBrand = executeGetDataBindParam($sqlGetBrand, "s", $params);
        $dataGetBrand = $dataGetBrand[0];

        $sqlGetAllProduct = "select * from product, laptop_specification
                                where product_type = 1 and brand = ?
                                and laptop_specification.product_id = product.product_id";
        $brandId = $dataGetBrand['id'];
        $allProduct = executeGetDataBindParam($sqlGetAllProduct, "i", [$brandId]);

    }
    if (empty($brand) && empty($slug)) {

        $sqlGetCate = "select * from category";

        $dataCate =  executeGetData($sqlGetCate);
        findAllChildCategories($dataCate, 1, $result);
        $params = array();
        $type = '';
        foreach ($result as $key => $value) {
            $params[] = '?';
            $type .= 'i';

        }
        $params = implode(',', $params);
        
        $sqlGetAllProduct = "select * from product, laptop_specification
                                where product_type = 1 and category_id in(".$params.")
                                and laptop_specification.product_id = product.product_id";
        $allProduct = executeGetDataBindParam($sqlGetAllProduct, $type, $result);

        
    }
    // echo "<pre>";
    // // var_dump($all_product);
    // echo "</pre>";


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
                            <a href="">Laptop</a>
                        </li>
                        <?php
                                if (!empty($dataGetCollection)) { 
                                    echo '<li>
                                            <a href="">'.$dataGetCollection['name'].'</a>
                                        </li>';
                                }

                                if (!empty($dataGetBrand)) { 
                                    echo '<li>
                                            <a href="">'.$dataGetBrand['name'].'</a>
                                        </li>';
                                }
                        ?>
                    </ul>
                </div>

                <?php
                    $heading = 'Laptop';
                    if (!empty($dataGetCollection)) { 
                        $heading = $dataGetCollection['name'];
                    }
                    if (!empty($dataGetBrand)) { 
                        $heading .= ' '.$dataGetBrand['name'];
                    }
                    echo '<h1 class="heading">'.$heading.'</h1>';
               ?>
                
            </div>
        </div>
        <div class="category-content">
            <div class="container">
                <div class="row">
                    <div class="col col-xl-3">
                        <div class="filter">
                            <p class="filter-title title">Lọc sản phẩm</p>


                            <div class="filter-group">
                                <p class="filter-group-title title">Nhu cầu sử dụng</p>
<?php
                        $sql = "select distinct product.category_id, category.name
                                from product, category
                                where product.product_type = 1
                                and category.id = product.category_id";
                        $dataListDemand = executeGetData($sql);
                        foreach ($dataListDemand as $key => $value) {
                            $check = '';
                            if (!empty($categoryId)) {
                                if ($value['category_id'] == $categoryId) 
                                    $check = 'checked';
                            }
                            echo '<div class="filter-group-item checkbox">
                                    <label>
                                        <input type="checkbox" '.$check.' class="common-selector-filter demand" value="'.$value['category_id'].'">
                                        <span>'.$value['name'].'</span>
                                    </label>
                                </div>';
                        }
?>
                            </div>



                            <div class="filter-group">
                                <p class="filter-group-title title">Hãng sản xuất</p>
<?php
                        $sql = "select distinct brand.id, brand.name from brand, product
                                where brand.id = product.brand
                                and product.product_type = 1";
                        $dataListBrand = executeGetData($sql);
                        foreach ($dataListBrand as $key => $value) {
                            $check = '';
                            if (!empty($brandId)) {
                                if ($value['name'] == $dataGetBrand['name'])
                                    $check = 'checked';
                            }
                           
                            echo '<div class="filter-group-item checkbox">
                                    <label>
                                        <input type="checkbox" '.$check.' class="common-selector-filter brand" value="'.$value['id'].'">
                                        <span>'.$value['name'].'</span>
                                    </label>
                                </div>';
                        }
?>
                            </div>


                            <div class="filter-group">
                                <p class="filter-group-title title">CPU - Bộ vi xử lý</p>
<?php
                        $sql = "select distinct cpu from laptop_specification order by cpu";
                        $dataListCpu = executeGetData($sql);
                        foreach ($dataListCpu as $key => $value) {
                            echo '<div class="filter-group-item checkbox">
                                    <label>
                                        <input type="checkbox" class="common-selector-filter cpu" value="'.$value['cpu'].'">
                                        <span>'.$value['cpu'].'</span>
                                    </label>
                                </div>';
                        }
?>
                            </div>


                            <div class="filter-group">
                            <p class="filter-group-title title">RAM</p>

<?php
                        $sql = "select distinct ram from laptop_specification";

                        $dataListRam = executeGetData($sql);
                        foreach ($dataListRam as $key => $value) {
                            echo '<div class="filter-group-item checkbox">
                                    <label>
                                        <input type="checkbox" class="common-selector-filter ram" value="'.$value['ram'].'">
                                        <span>'.$value['ram'].' GB</span>
                                    </label>
                                </div>';
                        }
?>

                            </div>

                            <div class="filter-group">
                                <p class="filter-group-title title">Ổ cứng</p>
<?php
                        $sql = "select distinct hard_drive_size from laptop_specification order by hard_drive_size";
                        $dataListHardDrive = executeGetData($sql);
                        foreach ($dataListHardDrive as $key => $value) {
                            echo '<div class="filter-group-item checkbox">
                                    <label>
                                        <input type="checkbox" class="common-selector-filter hard-drive" value="'.$value['hard_drive_size'].'">
                                        <span>'.$value['hard_drive_size'].'</span>
                                    </label>
                                </div>';
                        }
?>
                            </div>


                        </div>
                    </div>
                    <div class="col col-xl-9">
                        <div class="category-page-right">
                            <div class="product-list" id="result-filter-data">
                                <div class="row">
                            
                                </div>
                            </div>
                            <div class="pagination">
                                <ul class="pages">

                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>
</div>
 
 <?php
    include_once "partials/footer.php";
 ?>
<script>
    $(document).ready(function() {

        $('.common-selector-filter').click(function() {
            filterData();
        })

        filterData();

        $('.pagination .pages').click(function(e) {
            const btnPage = e.target.closest('.page')
            filterData({page: parseInt(btnPage.innerText)})
        })

    })

   
   


    function filterData(options) {
        let page = 1
        if (options) {
            page = options.page
        }

        let demand = getFilter('demand')
        let brand = getFilter('brand')
        let cpu = getFilter('cpu')
        let ram = getFilter('ram')
        let hardDrive = getFilter('hard-drive')
        $.ajax({
            url: "./api/product/product.php",
            type: "GET",
            data: {
                action: 'filter-data-laptop',
                page: page,
                brand: brand,
                cpu: cpu,
                demand: demand,
                ram: ram,
                hardDrive: hardDrive

            },
            dataType: "json",
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(result){
                console.log(result)
                const data = result.data
                $('#loading').hide();
                let html = ``;
                if (data.length > 0) {
                    let htmlPage = ``
                    for(let i = 0; i < result.totalPage; i++) {
                        let active = ''
                        if (page == (i + 1)) {
                            active = 'active'
                        }
                        htmlPage += `<li data-id=${i+1} class="page ${active}" style="padding: 10px; cursor: pointer;">${i+1}</li>`
                    }
                    
                    $('.pagination .pages').html(htmlPage)


                    $.each(data, function(index, item) {
                        let price = item['price']
                        let discount = item['discount'];
                        let priceDiscount = price
                        if (discount != 0) {
                            priceDiscount = price - (price * discount)/100;
                            priceDiscount = Math.round(priceDiscount/10000)*10000;
                        }
                        priceDiscount = new Intl.NumberFormat('de-DE').format(priceDiscount)
                        price = new Intl.NumberFormat('de-DE').format(price)

                        html += `<div class="col col-xl-3">
                                    <div class="product-item">
                                        <a href="./san-pham.php?slug=${item['slug']}" class="product-img">
                                            <img src="${item['thumbnail']}" alt="">
                                        </a>
                                        <div class="product-info">
                                            <a href="./san-pham.php?slug=${item['slug']}" class="product-name">LAPTOP ${item['name']} (${item['cpu']}/${item['ram']}GB RAM/${item['hard_drive_size']}/${item['screen']})</a>
                                            <div class="discount-info">`
                        if (discount == 0) {
                            html += `<span class="old-price"></span>
                                    <span class="discount"></span>`;
                        }
                        else html += ` <span class="old-price">${price}đ</span>
                                        <span class="discount">( Tiết kiệm: ${item['discount']}% )</span>`
                        html += `                                               
                                </div>
                                <p class="price">${priceDiscount}đ</p>`;
                        if (item['status'] == 1) {
                            html += `<div class="action">
                                                <p class="available"><i class="fa fa-check"></i> Còn hàng</p>
                                                <p class="cart" onclick="addToCart('${item['product_id']}', 1, '${item['product_type']}')"><i class="bi bi-cart3"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        }
                        else html += `<div class="action">
                                        <p class="sold-out"><i class="bi bi-telephone-fill"></i> Liên hệ</p>
                                    </div>
                                </div>
                            </div>
                        </div>`

                    
                    })
                }
                else html += `<h2>No Data Found</h2>`
                $('#result-filter-data .row').html(html)
            }
        });
    }

    function getFilter(classNameFilter) {
        let filterArray = []
        $('.' + classNameFilter + ':checked').each(function(){
            filterArray.push($(this).val())
        });
        return filterArray
    }
   
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