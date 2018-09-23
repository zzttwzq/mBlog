<?php

    include_once "util/curdclass.php";

    class learn extends curdclass {

        var $id;
        var $title;
        var $brief;
        var $text;
        var $datetime;
        var $share;
        var $comment;
        var $star;
        var $tag;
        var $score;
        var $category;

        public function resetDataBase(){

            $this->$manager->changeDataBase('MBLOG');
        }

        /* 添加数据 */
        public function addLearn ($array) {

            sendJsonWithArray($this->$manager->addData('LEARN',$array));
        }

        /* 删除数据 */
        public function deleteLearn ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                //查询数据
                sendJsonWithArray($this->$manager->deleteData("LEARN","where id=$ids"));
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 修改数据 */
        public function updateLearn ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->updateData('LEARN',$array,"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }

        /* 获取列表 */
        public function getLearnList ($array) {

            $size = $array['size'];
            $page = $array['page']*$size;
            $userid = $array['userId'];

            $result = $this->$manager->fastSelectTable('LEARN','*',"WHERE userid = $userid ORDER BY createTime DESC LIMIT $page,$size");            
            sendJsonWithArray($result);
        }

        /* 获取详情 */
        public function getLearnDetail ($array) {

            $ids = $array['id'];

            if ((int)$ids > 0){

                $result = $this->$manager->fastSelectTable('LEARN','*',"WHERE id = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"id 参数有误!",null);
            }
        }
    }
