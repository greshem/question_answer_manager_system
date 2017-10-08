<?php
include 'header.php';
require ('lib_db.php');

#$q_id=$_POST['q_id'];
#$question=trim($_POST['question']);
#$answer=trim($_POST['answer']);



$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password", "qa_shadow");
$query_string="select * from question where q_id=$_GET[q_id]; ";   
$db_data=$sqldb->query($query_string);
list(  $q_id,  $question,  ) = $sqldb->fetch_row($db_data);






$refer=$_SERVER['HTTP_REFERER'];

echo <<<EOF

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">question管理</li>
              <li class="active"><a href="create_question.php">新建question</a></li>
              <li><a href="question_list.php">question列表</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">
EOF;


		
echo <<<EOF



<div class="well">
<form class="form-horizontal" action='question_modifyok.php' method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">创建question</legend>
    </div>

	<input type="text" id="q_id" name = "q_id" value="$q_id" style = "display:none">

   <div class="control-group">
      <!-- question -->
      <label class="control-label"  for="question">问题</label>
	  <div class="controls">
        <input type="text"  class="" id="question" name="question" value="$question" placeholder="" > </input>
		<p class="help-block">请输入question</p>
      </div>
    </div>
 

   <div class="control-group">
      <!-- answer -->
      <label class="control-label"  for="answer">答案1</label>
	  <div class="controls">
        <input type="text"  class="" id="answer" name="answer" value="$answer" placeholder="" > </input>
		<p class="help-block">请输入answer</p>
      </div>
    </div>


   <div class="control-group">
      <!-- answer -->
      <label class="control-label"  for="answer">答案2</label>
	  <div class="controls">
        <input type="text"  class="" id="answer1" name="answer1" value="$answer" placeholder="" > </input>
		<p class="help-block">请输入answer</p>
      </div>
    </div>


   <div class="control-group">
      <!-- answer -->
      <label class="control-label"  for="answer">答案3</label>
	  <div class="controls">
        <input type="text"  class="" id="answer2" name="answer2" value="$answer" placeholder="" > </input>
		<p class="help-block">请输入answer</p>
      </div>
    </div>

   <div class="control-group">
      <!-- answer -->
      <label class="control-label"  for="answer">答案4</label>
	  <div class="controls">
        <input type="text"  class="" id="answer3" name="answer3" value="$answer" placeholder="" > </input>
		<p class="help-block">请输入answer</p>
      </div>
    </div>


   <div class="control-group">
      <!-- answer -->
      <label class="control-label"  for="answer">答案5</label>
	  <div class="controls">
        <input type="text"  class="" id="answer4" name="answer4" value="$answer" placeholder="" > </input>
		<p class="help-block">请输入answer</p>
      </div>
    </div>

		
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button type="submit" class="btn btn-primary">保  存</button> &nbsp;&nbsp;
        <a class="btn" href='question_list.php'>返 回</a>
        <span class='error'>$error</span> 
      </div>
    </div>
  </fieldset>
</form>
</div>

<script type="text/javascript">
	document.getElementById("question").focus();
</script>

EOF;

include 'bottom.php';
?>
