<?php

include_once PHP_COMMON_PATH . "/dbhelper.php";

class test extends dbhelper{

    public function get_test_list($array)
    {
        
        sendJson(0,'',null);
    }

    public function add_learn($array)
    {
        $learn = new learn();
        $result = $learn->add_data($array);
        sendJsonWithArray($result);
    }

    public function update_learn($array)
    {
        $learn = new learn();
        $result = $learn->update_data($array);
        sendJsonWithArray($result);
    }

    public function delete_learn($array)
    {
        $learn = new learn();
        $result = $learn->delete_data($array);
        sendJsonWithArray($result);
    }

    public function get_test_info($array)
    {
        sendJson(1212,'',null);
    }
}
