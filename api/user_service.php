<?php

include_once PHP_COMMON_PATH . "/dbhelper.php";
include_once 'user.php';

class user_service extends dbhelper
{

    public function get_user_list($array)
    {
        $user = new user();
        $result = $user->get_list($array);
        sendJsonWithArray($result);
    }

    public function add_user($array)
    {
        $user = new user();
        $result = $user->add_data($array);
        sendJsonWithArray($result);
    }

    public function update_user($array)
    {
        $user = new user();
        $result = $user->update_data($array);
        sendJsonWithArray($result);
    }

    public function delete_user($array)
    {
        $user = new user();
        $result = $user->delete_data($array);
        sendJsonWithArray($result);
    }

    public function get_user_info($array)
    {
        $user = new user();
        $result = $user->get_info($array);
        sendJsonWithArray($result);
    }

    public function login($array)
    {
        $username = $array['username'];
        $password = $array['password'];
        $condition = "WHERE (mobile = '$username' or nick_name = '$username') and password = '$password'";

        $result = $this->manager->fastSelectTable("user", "*", $condition);

        if ($result['code'] == 0) {

            $user_list = $result['data'];

            if (count($user_list) > 0) {

                // 生成token 并写入到数据库
                $token = md5($condition . 'mblog i love you' . time());

                // 写入到数据库
                $user = new user();
                $result2 = $user->update_data(array(
                    'user_id' => $user_list[0]['user_id'],
                    'token' => $token,
                    'last_login' => localtime()
                ));

                if ($result2['code'] == 0) {

                    $user_data = $user_list[0];
                    $user_data['token'] = $token;

                    sendJson(SERVICE_RESPOSE_SUCCESS, SERVICE_RESPOSE_SUCCESS_STRING, $user_data);
                } else {

                    sendJsonWithArray($result2);
                }
            } else {

                sendJson(SERVICE_OTHER_ERROR, "用户名密码错误", null);
            }
        } else {

            sendJsonWithArray($result);
        }
    }

    public function logout($array)
    {
        $headers = $this->getRequestHeader();
        $token = $headers['Token'];
        $condition = "WHERE token = '$token'";

        $result = $this->manager->fastSelectTable("user", "*", $condition);

        if ($result['code'] == 0) {

            $user_list = $result['data'];

            if (count($user_list) > 0) {

                // 重置用户 token
                $user = new user();
                $result2 = $user->update_data(array(
                    'user_id' => $user_list[0]['user_id'],
                    'token' => '',
                ));

                if ($result2['code'] == 0) {

                    sendJson(SERVICE_RESPOSE_SUCCESS, SERVICE_RESPOSE_SUCCESS_STRING, $user_list[0]);
                } else {

                    sendJsonWithArray($result2);
                }
            } else {

                sendJson(SERVICE_OTHER_ERROR, '用户已退出登录', null);
            }
        } else {

            sendJsonWithArray($result);
        }
    }

    public function iosInReview()
    {

        sendJson(SERVICE_RESPOSE_SUCCESS, SERVICE_RESPOSE_SUCCESS_STRING, null);
    }
}
