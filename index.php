<?php

    include_once "config.php";

    $config = new config();
    $config->configEnviroment();
    $config->configDataBase();

    //获得请求参数
    $params = explode('&', $_SERVER['QUERY_STRING']);

    if (count($params) >= 2) {

        $class = explode('=', $params[0])[1];
        $func = explode('=', $params[1])[1];      
        
        // // //请求授权
        // // $author = new authorization();
        // // $author->checkAuthorization($func);

        $validate = new httpHeaderValidate();
        $validate->validate($func,API_IGNORE_ARRAY);

        //请求过滤 (请求入口)
        $filter = new httpRequestFilter();
        $filter->listenRequest(API_PATH,$class,$func);
    }
    else{

        sendJson(SERVICE_REQUEST_URL_ERROR,SERVICE_REQUEST_URL_ERROR_STRING,null);
    }
?>