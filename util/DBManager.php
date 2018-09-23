<?php

    require_once "sendHandler.php";

    date_default_timezone_set('PRC'); //设置中国时区
    
    //================接口状态返回================
    //关于url
    define("SERVICE_RESPOSE_SUCCESS", 0); 
    define("SERVICE_REQUEST_URL_ERROR", 1);
    define("SERVICE_REQUEST_CLASS_ERROR", 2);
    define("SERVICE_REQUEST_METHOD_ERROR", 3);

    define("SERVICE_REQUEST_URL_ERROR_STRING", '请求接口有误！');
    define("SERVICE_REQUEST_CLASS_ERROR_STRING", '无效的请求类名！');
    define("SERVICE_REQUEST_METHOD_ERROR_STRING", '无效的请求方法！');
    define("SERVICE_RESPOSE_SUCCESS_STRING", '成功！');
    
    //关于验证
    define("SERVICE_TOKEN_INVALIDATE_ERROR", 4);
    define("SERVICE_AUTHOR_ERROR", 5);
    define("SERVICE_SIGN_ERROR_ERROR", 6);

    define("SERVICE_TOKEN_INVALIDATE_ERROR_STRING", '用户登录信息失效，请重新登录！');
    define("SERVICE_AUTHOR_ERROR_STRING", '用户权限不够！');
    define("SERVICE_SIGN_ERROR_STRING", '用户签名错误！');

    //关于参数
    define("SERVICE_PARAM_ERROR", 7); 

    //关于sql错误
    define("SERVICE_SQL_ERROR", 8);

    //其他
    define("SERVICE_OTHER_ERROR", 9);

    class DBManager {

        var $dsn;//数据源
        var $username;//用户名
        var $password;//密码
        var $pdo;//连接的pdo对象

        /**
         * 初始化方法
         */
        function __construct($dbname){

            if ($dbname == "" ||
                $dbname == '') {
    
            $this->dsn = "mysql:host=127.0.0.1";
            }else{
    
            $this->dsn = "mysql:host=127.0.0.1;dbname=$dbname";
            }
            $this->username = "root";
            $this->password = "1111";
            $this->pdo = new PDO($this->dsn,$this->username,$this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//设置错误模式
    
            //设置字符集
            $this->pdo->exec('SET NAMES utf8');
        }

        /**
         * 执行sql语句
         * $sql 要执行的语句
         * 返回 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function exec($sql){

            try {
    
                return array(
                    'code' => SERVICE_RESPOSE_SUCCESS,
                    'data' => $this->pdo->exec($sql),
                    'msg' => SERVICE_RESPOSE_SUCCESS_STRING,
                );
            } catch (PDOException $e) {
    
                return array(
                    'code' => SERVICE_SQL_ERROR,
                    'data' => null,
                    'msg' => $e->getMessage()."<br /> [SQL]:: $sql <br /> <br />",
                );
            }
        }

        /**
         * 执行sql语句
         * $sql 要执行的语句
         * 返回 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function query($sql){

            try {

                return array(
                    'code' => SERVICE_RESPOSE_SUCCESS,
                    'msg' => SERVICE_RESPOSE_SUCCESS_STRING,
                    'data' => $this->pdo->query($sql),
                );
            } catch (PDOException $e) {
    
                return array(
                    'code' => SERVICE_SQL_ERROR,
                    'msg' => $e->getMessage()."<br /> [SQL]:: $sql <br /> <br />",
                    'data' => null,
                );
            }
        }

        //====================数据库其他====================
        /**
         * 切换数据库
         * $dataBaseName 要切换的数据库名
         * return 消息字符串
         */
        public function changeDataBase ($dataBaseName){

            $sql = "USE $dataBaseName";
    
            $result = $this->exec($sql);
            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){
        
                //用json返回成功信息
                return "[数据库]:: 已经切换至：$dataBaseName! <br /> <br />";
            }
            else{
        
                //用json返回错误信息
                return "[ DBManager->changeDataBase() ]:: ".$result['msg'];
            }
        }

        //====================数据库操作====================
        /**
         * 创建数据库
         * $dataBaseName 要创建的数据库名
         * return 消息字符串
         */
        public function createDataBase($dataBaseName){

            $sql = "CREATE DATABASE $dataBaseName CHARACTER SET utf8"."  COLLATE utf8_general_ci";
    
            $result = $this->exec($sql);
            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){

                $message = $this->changeDataBase($dataBaseName);
    
                //用json返回成功信息
                return "[数据库]:: $dataBaseName 创建成功!".'<br />'.$message;
            }else{
    
                //用json返回错误信息
                return "[ DBManager->createDataBase() ]:: ".$result['msg'];
            }
        }

        /**
         * 删除数据库
         * $dataBaseName 要删除的数据库名
         * return 消息字符串
         */
        public function deleteDatabase($dataBaseName){

            $sql = "DROP DATABASE $dataBaseName";
    
            $result = $this->exec($sql);
            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){
    
                //用json返回成功信息
                return "[数据库]:: $dataBaseName 已经删除! <br /> <br />";
            }
            else{
    
                //用json返回错误信息
                return "[ DBManager->deleteDatabase() ]:: ".$result['msg'];
            }
        }

        /**
         * 创建表格
         * $tableName 要创建的表格名
         * $data 创建的数据（带有键值对的数组）
         * return 消息字符串
         */
        public function createTable($tableName,$data){

            $sql = "CREATE TABLE $tableName (";
            foreach ($data as $key => $value) {
    
                $sql = $sql.$key." ".$value.", ";
            }
            $sql = substr($sql,0,strlen($sql)-2);
            $sql = $sql.") ENGINE=InnoDB DEFAULT CHARSET='utf8'";
    
            $result = $this->exec($sql);
            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){
    
                //用json返回成功信息
                return "[数据库]:: $tableName 创建成功! <br /> <br />";
            }
            else{
    
                //用json返回错误信息
                return "[ DBManager->createTable() ]:: ".$result['msg'];
            }
        }

        /**
         * 删除表格
         * $tableName 要删除的表格名
         * return 消息字符串
         */
        public function deleteTable($tableName){

            $sql = "DROP TABLE $tableName";
    
            $result = $this->exec($sql);
            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){
    
                //用json返回成功信息
                return "[数据库]:: $tableName 删除成功! <br /> <br />";
            }else{
    
                //用json返回错误信息
                return "[ DBManager->deleteTable() ]:: ".$result['msg'];
            }
        }


        //====================数据操作====================
        /**
        * 添加数据
        * $tableName 添加数据的表格名
        * $data 字段和值的数组
        * return 结果{code:错误代码，msg:错误消息，data:数据}
        */
        public function addData($tableName,$data){

            $dataVaule = ") VALUES (";
            $sql = "INSERT INTO $tableName (";
            foreach ($data as $key => $value) {
    
                $sql = $sql.$key.", ";
                $dataVaule = $dataVaule." '$value', ";
            }
            $sql = substr($sql,0,strlen($sql)-2);
            $dataVaule = substr($dataVaule,0,strlen($dataVaule)-2);
            $sql = $sql.$dataVaule.");";
        
            return $this->exec($sql);
        }

        /**
         * 修改数据
         * $tableName 修改数据的表格名
         * $data 字段和值的数组
         * $filter 条件
         * return 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function updateData($tableName,$data,$filter){

            $sql = "UPDATE $tableName SET ";
            foreach ($data as $key => $value) {
    
                $sql = " $sql $key = '$value', ";
            }
            $sql = substr($sql,0,strlen($sql)-2);
            $sql = "$sql $filter;";
    
            $result = $this->exec($sql);

            //用json返回错误信息
            return $result;
        }


        /**
         * 删除数据
         * $tableName 删除数据的表格名
         * $filter 条件
         * return 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function deleteData($tableName,$filter){

            $sql = "DELETE FROM $tableName $filter";

            return $this->exec($sql);
        }


        /**
         * 返回最后增加的ID
         * return 最大的id
         */
        public function getLastID($tablename){

            $sql = "SELECT MAX(ID) FROM $tablename";
            foreach ($this->pdo->query($sql) as $row) {
    
                return (integer)$row['MAX(ID)'];
            }
        }

        /**
         * 返回表中所有的记录数量(有条件的)
         * return 所有数量
         */
        public function tableTotalCountWithCondition($tablename,$condition){

            $sql = "SELECT COUNT(1) FROM $tablename $condition";
            foreach ($this->pdo->query($sql) as $row) {
    
                return (integer)$row['COUNT(1)'];
            }
        }

        /**
         * 返回表中所有的记录数量
         * return 所有数量
         */
        public function tableTotalCount($tablename){

            $sql = "SELECT COUNT(1) FROM $tablename";
            foreach ($this->pdo->query($sql) as $row) {
    
                return (integer)$row['COUNT(1)'];
            }
        }


        /**
         * 查找数据（直接返回json数据，不需要处理）
         * $tableName 查找数据的表格名
         * $fields 字段
         * $condition 条件
         * return 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function fastSelectTable($tableName,$fields,$condition){

            //转换成sql语句并转大写
            $sql = "SELECT $fields FROM $tableName $condition;";
            $sql = strtoupper($sql);

            $listArray = array();
            $result = $this->query($sql);

            if ($result['code'] == SERVICE_RESPOSE_SUCCESS){

                foreach($result['data'] as $row){
                    
                    $dataArray = array();
                    $arrayKeys = array_keys($row);

                    foreach ($arrayKeys as $key){

                        if (! is_numeric($key)) {

                            $dataArray[$key] = $row[$key];
                        }
                    }
                    Array_push($listArray,$dataArray);
                }

                return array(
                    'code' => SERVICE_RESPOSE_SUCCESS,
                    'msg' => $sql,//SERVICE_RESPOSE_SUCCESS_STRING,
                    'total' => $this->tableTotalCountWithCondition($tableName,$condition),
                    'data' => $listArray,
                );
            }
            else{

                return $result;
            }
        }


        /**
         * 查找数据 (需要自己去处理里面的数据)
         * $tableName 查找数据的表格名
         * $fields 字段
         * $condition 条件
         * return 结果{code:错误代码，msg:错误消息，data:数据}
         */
        public function selectFromTable($tableName,$fields,$condition){

            //转换成sql语句并转大写
            $sql = "SELECT $fields FROM $tableName $condition";
            $sql = strtoupper($sql);
    
            return $this->query($sql);
        }
    }

?>