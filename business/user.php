<?php

    include_once "util/curdclass.php";

    class user extends curdclass {

        var $userId;
        var $realname;
        var $nickname;
        var $mobile;
        var $age;
        var $cent;
        var $token;
        var $lastloginDate;
        var $level;
        var $yanzhen;
        var $password;
        var $usrimg;

        public function resetDataBase(){

            $this->$manager->changeDataBase('MBLOG');
        }

        /* 添加数据 */
        public function addUser ($array) {

            sendJsonWithArray($this->$manager->addData('USER',$array));
        }

        /* 删除数据 */
        public function deleteUser ($array) {

            $ids = $array['userId'] ? $array['userId'] : $_GET['userId'];

            if ((int)$ids > 0){

                //查询数据
                sendJsonWithArray($this->$manager->deleteData("USER","where userId = $ids"));
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"userId 参数有误!",null);
            }
        }

        /* 修改数据 */
        public function updateUser ($array) {

            $ids = $array['userId'] ? $array['userId'] : $_GET['userId'];

            if ((int)$ids > 0){

                $result = $this->$manager->updateData('USER',$array,"WHERE userId = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"userId 参数有误!",null);
            }
        }

        /* 获取列表 */
        public function getUserList ($array) {

            $page = $array['page'] ? $array['page'] : $_GET['page'];
            $size = $array['size'] ? $array['size'] : $_GET['size'];

            $result = $this->$manager->fastSelectTable('USER','*',"ORDER BY createTime DESC LIMIT $page,$size");            
            sendJsonWithArray($result);
        }

        /* 获取详情 */
        public function getUserDetail ($array) {

            $ids = $array['userId'] ? $array['userId'] : $_GET['userId'];

            if ((int)$ids > 0){

                $result = $this->$manager->fastSelectTable('USER','*',"WHERE userId = $ids");
                sendJsonWithArray($result);
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,"userId 参数有误!",null);
            }
        }

        /* 登录接口 */
        public function login ($array){

            $username = $array['username'] ? $array['username'] : $_GET['username'];
            $mobile = $array['mobile'] ? $array['mobile'] : $_GET['mobile'];
            $password = $array['password'] ? $array['password'] : $_GET['password'];

            $condition = '';
            if (strlen($username) > 0){

                $condition = "WHERE nickname = $username and password = '$password'";
            }
            else if (strlen($mobile) > 0){
            
                $condition = "WHERE mobile = $mobile and password = '$password'";
            }    
        
            if (strlen($condition) > 0){

                $findResult = $this->$manager->fastSelectTable('USER','*',$condition);

                if ($findResult['code'] == SERVICE_RESPOSE_SUCCESS){

                    if (count($findResult['data']) > 0){

                        $userData = $findResult['data'][0];

                        $token = md5($condition.'mblog i love you'.time());
    
                        $ids = $userData['userId'];
                        $result = $this->$manager->updateData('USER',array(
                            'token' => $token,
                        ),"WHERE userId = '$ids'");
        
                        //新的token
                        $userData['token'] = $token;

                        sendJson(SERVICE_RESPOSE_SUCCESS,SERVICE_RESPOSE_SUCCESS_STRING,$userData);
                    }
                    else{

                        sendJson(SERVICE_OTHER_ERROR,"用户名或密码错误!",null);
                    }
                }
                else{

                    sendJsonWithArray($findResult);
                }
            }
            else{

                sendJson(SERVICE_PARAM_ERROR,'登录账号不能为空！',null);
            }
        }

        /* 登出接口 */
        public function logout ($array){

            $ids = $array['userId'] ? $array['userId'] : $_GET['userId'];

            $findResult = $this->$manager->fastSelectTable('USER','*',"WHERE userId = '$ids'");

            if ($findResult['code'] == SERVICE_RESPOSE_SUCCESS){

                if (count($findResult['data']) > 0){

                    $result = $this->$manager->updateData('USER',array(
                        'token' => '',
                    ),"WHERE userId = '$ids'");

                    sendJsonWithArray($result);
                }   
                else {

                    sendJson(SERVICE_OTHER_ERROR,"用户账号不存在!",null);
                }
            }
        }
    }
