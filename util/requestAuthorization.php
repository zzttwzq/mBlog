<?php

    include_once 'DBManager.php';

    class authorization {

        public function checkAuthorization ($function) {

            $manager = new DBManager('MBLOG');
            $result = $manager->fastSelectTable('REQUEST_AUTHOR','*',"WHERE function = '$function'");            

            if (count($result['data']) == 0){

                sendJson(SERVICE_AUTHOR_ERROR,"该方法未录入到数据库中！",null);
                die();
            }
            else{

                $priority = (integer)$result['data'][0]['priority'];
    
                if ($priority > 0) {

                    sendJson(SERVICE_AUTHOR_ERROR,SERVICE_AUTHOR_ERROR_STRING,null);
                    die();
                }
            }
        }
    }
?>
