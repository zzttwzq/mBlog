<?php

    include_once "DBManager.php";

    class curdclass {

        var $manager;

        function __construct () {

            //创建manager
            $this->$manager = new DBManager("");
            $this->resetDataBase();
        }

        public function resetDataBase() {

        }
    }

?>
