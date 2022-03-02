<?php

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'get-list-laptop-brand':
                getListLaptopBrand();
                break;
            
        }
    }

    function getListLaptopBrand() {
        define('BASE_URL', '../');
        include_once "../database/dbhelper.php";
        $sql = "select distinct brand.slug, brand.name from brand, product
                where brand.id = product.brand
                and product.product_type = 1";
        $data = executeGetData($sql);
       
        $out = array();
        foreach ($data as $key => $value) {
            $out[] = array(
                'slug' => $value['slug'],
                'name' => $value['name']
            );
        }
        echo json_encode($out);
    }

?>