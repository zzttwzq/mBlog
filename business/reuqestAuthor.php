<?php

    include_once "util/curdclass.php";

    class requestAuthor extends curdclass {

        var $id;
        var $class;         //类名
        var $function;      //方法名
        var $description;   //描述
        var $priority;      //优先级，0 表示优先级最低

        public function resetDataBase(){

            $this->$manager->changeDataBase('MBLOG');
        }

        /* 添加数据 */
        public function addRequest ($array) {

            sendJsonWithArray($this->$manager->addData('REQUEST_AUTHOR',$array));
        }

        /* 删除数据 */
        public function deleteRequest ($array) {

            $ids = $array['id'] ? $array['id'] : $_GET['id'];

            if ((int)$ids > 0){

                //查询数据
                sendJsonWithArray($this->$manager->deleteData("REQUEST_AUTHOR","where id=$ids"));
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 修改数据 */
        public function updateRequest ($array) {

            $ids = $array['id'] ? $array['id'] : $_GET['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->updateData('REQUEST_AUTHOR',$array,"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 获取列表 */
        public function getRequestList ($array) {

            $page = $array['page'] ? $array['page'] : $_GET['page'];
            $size = $array['size'] ? $array['size'] : $_GET['size'];

            $result = $this->$manager->fastSelectTable('REQUEST_AUTHOR','*',"ORDER BY createTime DESC LIMIT $page,$size");            
            sendJsonWithArray($result);
        }

        /* 获取详情 */
        public function getRequesttDetail ($array) {

            $ids = $array['id'] ? $array['id'] : $_GET['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->fastSelectTable('REQUEST_AUTHOR','*',"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }
    }

?>
