<?php

    include_once 'DBManager.php';

    class httpHeaderValidate {

        public function validate ($function) {

            $ignore = false;
            $ignoredArray = array(
                'addUser',
                'getUserList',
                'login',
            );

            foreach ($ignoredArray as $item){

                if ($item === $function){

                    $ignore = true;
                    break;
                }
            }

            /* 判断接口是否需要 */
            if (!$ignore){

                if ($this->validateToken() == false){

                    sendJson(SERVICE_TOKEN_INVALIDATE_ERROR,SERVICE_TOKEN_INVALIDATE_ERROR_STRING,null);
                    die();
                }
                else if ($this->validateSign() == false){
    
                    sendJson(SERVICE_SIGN_ERROR,SERVICE_SIGN_ERROR_STRING,null);
                    die();
                }
            }
        }

        public function validateToken () {

            $headers = $this->getRequestHeader();

            $token = $headers['Token'];
            $userid = $headers['Userid'];

            $manager = new DBManager('MBLOG');
            $result = $manager->fastSelectTable('USER','*',"WHERE userId = '$userid' AND token = '$token'");            
            
            if (count($result['data']) == 0){
                return false;
            }

            return ture;
        }

        public function validateSign () {

            $headers = $this->getRequestHeader();

            //5s以后超时
            $timeLimit = (integer)$_SERVER['REQUEST_TIME'] - (integer)$headers['Timesnamp']/1000;

            if ($timeLimit > 5){

                return false;
            }

            $str = 'mblog is very good'.$headers['Timesnamp'].$headers['Userid'];
            $str = md5($str);

            if ($str === $headers['Sign']){

                return true;
            }
            else {
                
                return false;
            }
        }

        public function getRequestHeader (){

            $headers = array();

            foreach ($_SERVER as $name => $value)
            {
                if (substr($name, 0, 5) == 'HTTP_')
                {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }

            return $headers;
        }
    }
?>