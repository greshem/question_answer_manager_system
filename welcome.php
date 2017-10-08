<?php
include 'header.php';

echo <<<EOF

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">

              <li class="nav-header">question管理</li>
              <li class="active"><a href="create_question.php">新建question</a></li>
              <li><a href="question_list.php">question列表</a></li>
              <li><a href="question_search.php">question搜索</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">

EOF;


#include 'lib_db.php';
include 'stat_lib.php';

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");

$count_question=get_today_question($sqldb);
$count_answer=get_today_answer($sqldb);

echo <<<EOF

		<div class="well">
		<h3>欢迎您！ </h3>
        <h3> 今天一共输入$count_question 个问题</h3>
        <h4> 今天一共输入$count_answer  个回答</h4>
		</div>

EOF;

include 'bottom.php';
?>
