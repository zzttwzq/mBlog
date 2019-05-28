<?php

include_once PHP_COMMON_PATH . "/dbhelper.php";
include_once 'learn.php';

class learn_service extends dbhelper{

    public function get_learn_list($array)
    {
        $page = (int)$array["page"];
        $size = (int)$array["size"]*$page;

        if ($size == 0) {
            $size = 20;
        }

        $result = $this->manager->fastSelectTable(
            "learn",
            "learn.create_time,learn.learn_id,learn.title,learn.brief,learn.share,learn.star,learn.tags,learn.comment,learn.subject,learn.category,user.avatar,user.nick_name",
            "LEFT join user on learn.user_id = user.user_id LIMIT $page,$size"
        );
        sendJsonWithArray($result);
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

    public function get_learn_info($array)
    {
        $id = (int)$array['learn_id'];

        $result = $this->manager->fastSelectTable(
            "learn",
            "learn.text,learn.create_time,learn.learn_id,learn.title,learn.brief,learn.share,learn.star,learn.tags,learn.comment,learn.subject,learn.category,user.avatar,user.nick_name",
            "LEFT join user on learn.user_id = user.user_id WHERE learn.learn_id = '$id'"
        );
        sendJsonWithArray($result);
    }
}