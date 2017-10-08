<?php
include 'header.php';
#require ('lib_db.php');
include("stat_lib.php");

#$q_id=$_POST['q_id'];
#$question=trim($_POST['question']);
#$answer=trim($_POST['answer']);


if(isset($_GET['q_id']))
{
$q_id=$_GET['q_id'];
$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password", "qa_shadow");
$query_string="select * from question where q_id=$q_id; ";   
$db_data=$sqldb->query($query_string);
list(  $q_id,  $question,  ) = $sqldb->fetch_row($db_data);
}




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


		
echo <<<EOF
<div class="well">
<form class="form-horizontal" action='question_list.php' method="GET">
  <fieldset>
    <div id="legend">
      <legend class="">search</legend>
    </div>

 

   <div class="control-group">
      <!-- keyword -->
      <label class="control-label"  for="keyword">问题</label>
	  <div class="controls">
        <input type="text"  class="" id="keyword" name="keyword" value="$keyword" placeholder="" > </input>
		<p class="help-block">请输入keyword</p>

        <select name=user>
            <option value="" selected=""> all </option>          
EOF;

    $sqldb2=new db;
    $sqldb2->connect_db("localhost", "root", "password", "qa_shadow");

        $users=get_users($sqldb2);
        foreach ($users as $key=>$value) 
        {
        echo <<<EOF
            <option value="$value" > $value </option>          
EOF;
        }


echo <<<EOF
        </select>
      </div>
    </div>
 


		
		
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button type="submit" class="btn btn-primary">search</button> &nbsp;&nbsp;
        <a class="btn" href='question_list.php'>返 回</a>
        <span class='error'>$error</span> 
      </div>
    </div>
  </fieldset>
</form>
</div>

EOF;

include 'bottom.php';
?>
