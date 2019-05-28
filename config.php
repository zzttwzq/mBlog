<?php

class config {

    function configEnviroment () {

        include_once "../php_common/sendHandler.php";
        include_once "../php_common/requestAuthorization.php";
        include_once "../php_common/httpHeaderValidate.php";
        include_once "../php_common/httpRequestFilter.php";

        // 项目根目录
        define('APP_ROOT', trim(__DIR__ . '/'));
        // 项目api路径
        define('API_PATH', APP_ROOT."api/");
        // 项目不需要验证token，签名等登录信息的接口数组
        define('API_IGNORE_ARRAY', array(
            'login',
            'logout',
            'get_learn_list',
            'get_learn_info',
            'get_test_list',
            'get_test_info',
        ));
        // 加盐的字符串
        define('SALT_STRING', "mblog is very good");
    }

    function configDataBase () {

        // 数据库地址
        define('DB_HOST', "127.0.0.1");
        // 数据库用户名
        define('DB_USERNAME', "root");
        // 数据库密码
        define('DB_PWD', "1111");
        // 数据库名
        define('DB_NAME', "mblog");
    }
}