<?php

    class httpRequestFilter {

        public function listenRequest ($class,$func){

            if (strlen($class) == 0){

                sendJson(SERVICE_REQUEST_CLASS_ERROR,SERVICE_REQUEST_CLASS_ERROR_STRING,null);
            }
            else if (strlen($func) == 0){

                sendJson(SERVICE_REQUEST_METHOD_ERROR,SERVICE_REQUEST_METHOD_ERROR_STRING,null);
            }
            else{

                //把class加载进来   
                $path = APPPATH.'business/'.$class .'.php';
                include($path);

                $obj = new $class();

                $raw_post_data = file_get_contents('php://input');
                $jsonData = json_decode($raw_post_data,true);

                call_user_func_array(

                    //调用内部function   
                    array($obj, $func),

                    //传递参数   
                    array($jsonData)
                );
            }
        }
    }
?>