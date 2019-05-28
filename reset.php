<?php

  include_once "../php_common/sendHandler.php";
  include_once "../php_common/DBManager.php";
  include_once "api/user.php";
  include_once "api/learn.php";
  include_once "config.php";

  $config = new config();
  $config->configEnviroment();
  $config->configDataBase();
  
  $manager = new DBManager(DB_HOST,'',DB_USERNAME,DB_PWD);
  
  echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';
  echo $manager->deleteDatabase('mblog');
  echo $manager->createDataBase('mblog').'<br />';

  echo '<br> <br> >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';
  echo '创建 项目 数据表 user'.'<br />';
  $userDataArray = array(
    'user_id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'real_name' => "varchar(40)",
    'nick_name' => "varchar(20)",
    'mobile' => "varchar(11) unique",
    'age' => "int",
    'cent' => "int",
    'token' => "varchar(40)",
    'last_login' => "varchar(20)",
    'level' => "int",
    'code' => "varchar(8)",
    'password' => "varchar(40)",
    'avatar' => "varchar(100)",
  );
  echo $manager->createTable('user',$userDataArray);

  echo '<br> <br> >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';
  echo '创建 项目 数据表 learn'.'<br />';
  $learnDataArray = array(
    'learn_id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'title' => "varchar(30)",
    'brief' => "TEXT(1000)",
    'text' => "TEXT(200000)",
    'create_time' => "datetime",
    'share' => "int",
    'comment' => "int",
    'star' => "int",
    'subject' => "varchar(30)",
    'category' => "varchar(10)",
    'tags' => "varchar(300)",
    'user_id' => "int",
    'project_id' => "int",
  );
  echo $manager->createTable('learn',$learnDataArray);

  // echo '<br> <br> >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> <br>';
  // echo '3. 创建 项目 数据表 project'.'<br />';
  // $projectDataArray = array(
  //   'projectId' => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
  //   'title' => "VARCHAR(50)",
  //   'tag' => "VARCHAR(30)",
  //   'lastItem' => "VARCHAR(100)",
  //   'createTime' => "DATETIME",
  //   'linkLearnID' => "INT",
  //   'listArray' => "VARCHAR(20000)",
  //   'img' => "VARCHAR(100)",
  //   'progress' => "INT(10)",
  //   'userId' => "INT"
  // );
  // echo $manager->createTable('PROJECT',$projectDataArray);



  echo '插入数据 user'.'<br />';
  $dataArray = array(
    'real_name' => "吴志强",
    'nick_name' => "wzq",
    'password' => "96e79218965eb72c92a549dd5a330112",
    'age' => "27",
    'mobile' => "13023628319",
    'cent' => "10",
    'token' => "iaus0d98fuq0weorhqlwerh",
    'last_login' => "2018-9-1 12:23:23",
    'level' => "10",
    'code' => '1212',
    'avatar' => "http://www.zzttwzq.top/resource/image/logo1.png",
  );
  $user = new user();
  sendJsonWithArray($user->add_data($dataArray));
  echo '<br />';

  echo '插入数据 learn'.'<br />';
  $dataArray = array(
    'title' => "angular学习",
    'brief' => "angular概览",
    'text' => "[string]啥也没有[end]",
    'create_time' => "2017-11-27 15:45",
    'share' => 0,
    'comment' => 0,
    'star' => 0,
    'tags' => "ios,ios",
    'subject' => "移动端",
    'category' => "angular",
    'user_id' => 1,
    'project_id' => 1,
  );
  $learn = new learn();
  sendJsonWithArray($learn->add_data($dataArray));
  echo '<br />';
  sendJsonWithArray($learn->add_data($dataArray));
  echo '<br />';
  sendJsonWithArray($learn->add_data($dataArray));
  echo '<br />';

  // echo '4. 插入数据 project'.'<br />';
  // $project = new project();
  // $projectArray = array(
  //   'title' => "学习swift",
  //   'tag' => "swift,ios",
  //   'lastItem' => "第一章，学习变量",
  //   'createTime' => "2018-8-31 15:11:26",
  //   'linkLearnID' => "0",
  //   'listArray' => "asdfasdfasdfasdfasdf",
  //   'img' => "asdfasdfasdf",
  //   'progress' => "10",
  //   'userId' => "1"
  // );
  // echo $project->add_data($projectArray).'<br />';
  // echo '<br />';