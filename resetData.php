
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>重置博客第五版数据</title>
</head>
<body>

  <script type="text/javascript">

    if(confirm("请确保数据是否备份，在执行！！！！！是否执行此操作？")){

    }
    else{

      alert("hahah");
    }
    
  </script>

<?php

  include_once "util/DBManager.php";
  include_once "business/project.php";
  include_once "business/user.php";
  include_once "business/learn.php";
  include_once "business/pic.php";
  include_once "business/reuqestAuthor.php";
  
  $manager = new DBManager('');
  
  echo '1. 删除 MBLOG...'.'<br />';
  echo $manager->deleteDatabase('MBLOG').'<br />';

  echo '2. 创建数据库 MBLOG...'.'<br />';
  echo $manager->createDataBase('MBLOG').'<br />';



  echo '3. 创建 项目 数据表 project'.'<br />';
  $projectDataArray = array(
    'projectId' => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'title' => "VARCHAR(50)",
    'tag' => "VARCHAR(30)",
    'lastItem' => "VARCHAR(100)",
    'createTime' => "DATETIME",
    'linkLearnID' => "INT",
    'listArray' => "VARCHAR(20000)",
    'img' => "VARCHAR(100)",
    'progress' => "INT(10)",
    'userId' => "INT"
  );
  echo $manager->createTable('PROJECT',$projectDataArray).'<br />'.'<br />';


  echo '4. 插入数据 project'.'<br />';
  $project = new project();
  $projectArray = array(
    'title' => "学习swift",
    'tag' => "swift,ios",
    'lastItem' => "第一章，学习变量",
    'createTime' => "2018-8-31 15:11:26",
    'linkLearnID' => "0",
    'listArray' => "asdfasdfasdfasdfasdf",
    'img' => "asdfasdfasdf",
    'progress' => "10",
    'userId' => "1"
  );
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';
  echo $project->addProject($projectArray).'<br />';


  echo '5. 创建 项目 数据表 user'.'<br />';
  $user = new user();
  $userDataArray = array(
    'userId' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'realname' => "varchar(15)",
    'nickname' => "varchar(15) unique",
    'password' => "varchar(15)",
    'age' => "int",
    'mobile' => "varchar(11)",
    'cent' => "int",
    'token' => "varchar(40)",
    'lastlogin' => "varchar(20)",
    'level' => "int",
    'usrimg' => "varchar(100)",
  );
  echo $manager->createTable('USER',$userDataArray).'<br />'.'<br />';


  echo '6. 插入数据 user'.'<br />';
  $userArray = array(
    'realname' => "吴志强",
    'nickname' => "小吴",
    'password' => "asdfasdfasdf",
    'age' => "27",
    'mobile' => "13023628319",
    'cent' => "10",
    'token' => "iaus0d98fuq0weorhqlwerh",
    'lastlogin' => "2018-9-1 12:23:23",
    'level' => "10",
    'usrimg' => "http://localhost/mblog/resource/image/111.png",
  );
  echo $user->addUser($userArray).'<br />';


  echo '7. 创建 项目 数据表 learn'.'<br />';
  $learn = new learn();
  $learnDataArray = array(
    'learnId' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'title' => "varchar(30)",
    'brief' => "varchar(100)",
    'text' => "varchar(20000)",
    'datetime' => "datetime",
    'share' => "int",
    'comment' => "int",
    'star' => "int",
    'tag' => "varchar(30)",
    'category' => "varchar(10)",
    'usrid' => "int",
    'projectId' => "int",
  );
  echo $manager->createTable('LEARN',$learnDataArray).'<br />'.'<br />';


  echo '8. 插入数据 learn'.'<br />';
  $learnArray = array(
    'title' => "angularjs从入门到出门",
    'brief' => "angular概览",
    'text' => "啥也没有",
    'datetime' => "2017-11-27 15:45",
    'share' => "100",
    'comment' => "99",
    'star' => "10",
    'tag' => "angular",
    'category' => "iOS",
    'usrid' => "1",
    'projectId' => "1",
  );
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';
  echo $learn->addLearn($learnArray).'<br />';


  echo '9. 创建 接口权限 数据表 REQUEST_AUTHOR'.'<br />';
  $request = new requestAuthor();
  $requestDataArray = array(
    'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    'class' => "varchar(50)",
    'function' => "varchar(50) UNIQUE",
    'description' => "varchar(1000)",
    'priority' => 'int',
  );
  echo $manager->createTable('REQUEST_AUTHOR',$requestDataArray).'<br />'.'<br />';


  echo '10. 插入数据 REQUEST_AUTHOR'.'<br />';
  $requestArray = array(
    'class' => "user",
    'function' => "addUser",
    'description' => "varchar(1000)",
    'priority' => 0,
  );
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';
  echo $request->addRequest($requestArray).'<br />';

 ?>
