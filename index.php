<?php

    // header('Content-Type:text/html;charset=utf-8');/*设置php编码为utf-8*/

    //定义application路径   
    define('APPPATH', trim(__DIR__ . '/'));
    include_once "util/sendHandler.php";

    //获得请求地址   
    $url = $_SERVER['PHP_SELF'];
    $array = explode('/', $url);

    if (count($array) >= 5) {

        $class = $array[3];
        $func = $array[4];      
        
        // //请求授权
        // include_once "util/requestAuthorization.php";
        // $author = new authorization();
        // $author->checkAuthorization($func);
     
        //请求监听token,sign等
        include_once "util/httpHeaderValidate.php";
        $validate = new httpHeaderValidate();
        $validate->validate($func);

        //请求过滤 (请求入口)
        include_once "util/httpRequestFilter.php";
        $filter = new httpRequestFilter();
        $filter->listenRequest($class,$func);
    }
    else{

        sendJson(SERVICE_REQUEST_URL_ERROR,SERVICE_REQUEST_URL_ERROR_STRING,null);
    }
?>