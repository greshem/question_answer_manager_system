<?php
include 'header.php';

echo <<<EOF


<script type="text/javascript">
	setTitleActive('sta_title');
</script>

<div class="container-fluid">
      <div class="row-fluid">
    <div class="span2">
      <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">answer管理</li>
              <li class="active"><a href="create_question.php">新建Answer</a></li>
              <li><a href="question_list.php">Answer列表</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
            <div class="btn-toolbar">
                <a class="btn btn-primary" href="create_answer.php" >新 建</a>
                <button class="btn">导 入</button>
                <button class="btn">导 出</button>
            </div>
EOF;

include("stat_lib.php");
$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");


$all_question =get_all_question_count($sqldb);
$all_answer=   get_all_answer_count($sqldb);


$today_question=get_today_question($sqldb);
$today_answer=get_today_answer($sqldb);

$users=  get_today_active_uers($sqldb);
#$str_users=array_to_str($users);


echo <<<EOF
		
        <div class="well">
            <h5>累计 Question:   $all_question 个</h5>
            <h5>累计 Answer:     $all_answer  个</h5>
            <h5>今日输入问题: $today_question 个</h5>
            <h5>今日输入答案: $today_answer   个</h5>

            <hr> 
            <p>
            <h3> Top 10: 今天活跃Creactor</h3><br>
EOF
;

 

echo <<<EOF
		<div class="panel panel-default">
            <!-- Table -->
            <table class="table">
              <thead>
                <tr>
                  <th align="center">姓名</th>
                  <th align="center">输入Question总数</th>
                  <th align="center">输入Anwser总数</th>
                </tr>
              </thead>
			  <tbody>
EOF;
	foreach ($users as $key=>$value) {
		 $question_count=get_today_users_question_count($sqldb, $value);
		 $anwser_count=get_today_users_answer_count($sqldb, $value);
echo <<<EOF
			<tr>
			  <td>$value</td>
			  <td>$question_count</td>
			  <td>$anwser_count</td>
			</tr>
EOF;
	}
	
                
                
              
  //$str_users;
echo <<<EOF
					</tbody>
					</table>
				  </div>
				</div>
     

            </p>

        </div>
    </div>

</div> 

EOF;


include("bottom.php");
?>
