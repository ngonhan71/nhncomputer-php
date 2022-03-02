<?php
    define('BASE_URL', '../../');
    echo "<h1>Index admin</h1>";
    // include_once "partials/header.php";
    include_once "../../database/dbhelper.php";
    $sql = "select * from category";
    $data =  execute_sql_get_data($sql);
    var_dump($data);
?>