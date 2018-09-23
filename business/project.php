<?php

    include_once "util/curdclass.php";

    class project extends curdclass {

        var $id;
        var $title;
        var $tag;
        var $lastItem;
        var $createTime;
        var $linkLearnID;
        var $listArray;
        var $img;
        var $progress;

        public function resetDataBase(){

            $this->$manager->changeDataBase('MBLOG');
        }

        /* 添加数据 */
        public function addProject ($array) {

            sendJsonWithArray($this->$manager->addData('PROJECT',$array));
        }

        /* 删除数据 */
        public function deleteProject ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                //查询数据
                sendJsonWithArray($this->$manager->deleteData("PROJECT","where id=$ids"));
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 修改数据 */
        public function updateProject ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->updateData('PROJECT',$array,"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 获取列表 */
        public function getProjectList ($array) {

            $page = $array['page'];
            $size = $array['size'];

            $result = $this->$manager->fastSelectTable('PROJECT','*',"ORDER BY createTime DESC LIMIT $page,$size");            
            sendJsonWithArray($result);
        }

        /* 获取详情 */
        public function getProjectDetail ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->fastSelectTable('PROJECT','*',"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }
    }

?>
