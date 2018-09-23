<?php

    /**
    * 发送json数据
    * $code 状态
    * $msg 提示信息
    * $data 返回的数据都放这里面(空的话就返回空字符串)
    */
    function sendJson($code,$msg,$data){

        //用json信息
        $resultArray = array('code' => $code, 'msg' => $msg, 'data' => $data);
        echo json_encode($resultArray);
    }


    /**
    * 发送json数据 带有total
    * $code 状态
    * $msg 提示信息
    * $data 返回的数据都放这里面(空的话就返回空字符串)
    */
    function sendJsonWithTotal($code,$msg,$total,$data){

        //用json信息
        $resultArray = array('total' => $total,'code' => $code, 'msg' => $msg, 'data' => $data);
        echo json_encode($resultArray);
    }     


    /**
    * 发送json数据
    * $code 状态
    * $msg 提示信息
    * $data 返回的数据都放这里面(空的话就返回空字符串)
    */
    function sendJsonWithArray($array){

        echo json_encode($array);
    }


    /**
    * 发送json数据 带有total
    * $code 状态
    * $msg 提示信息
    * $data 返回的数据都放这里面(空的话就返回空字符串)
    */
    function sendJsonWithTotalAndArray($total,$array){

        $array['total'] = $total;
        echo json_encode($array);
    }    

?>