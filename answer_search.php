<?php
include 'header.php';
#require ('lib_db.php');

include ("lib_db.php");

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


              <li class="nav-header">answer管理</li>
              <li ><a href="create_question.php?q_id=$q_id">新建Answer</a></li>
              <li><a href="answer_list.php?q_id=$q_id">Answer列表</a></li>
              <li class="active"><a href="answer_search.php">answer搜索</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">
EOF;



#$_GET['keyword']="电影";
if(isset($_GET['keyword']))
{
    $keyword=$_GET['keyword'];
    echo "搜索 $keyword <br>";

    echo <<<EOF
		<div class="panel panel-default">
            <!-- Table -->
            <table class="table">
              <thead>
                <tr>
                  <th align="center"></th>
                </tr>
              </thead>
			  <tbody>
EOF;
    
    #include ("lib_db.php");
    $sqldb=new db;
    $sqldb->connect_db("localhost", "root", "password","qa_shadow");

    $sqldb2=new db;
    $sqldb2->connect_db("localhost", "root", "password","qa_shadow");

    #$sqldb->query("SELECT answer.*   WHERE     content like '%$keyword%'  ");
    # SELECT *   from answer  where  content like "%电影%"
    $sqldb->query("SELECT answer.*  from answer   WHERE     content like '%$keyword%'  ");
    while(list(  $a_id , $parent_q_id , $content , $user, $create_at, $score,$like_item)=$sqldb->fetch_row())
    {
        $question=$sqldb2->get_question_with_q_id($parent_q_id);
        print "<tr><td><a href=answer_list.php?q_id=$parent_q_id>q:$question</a> </td>\n"; 
        print "<td>a:".$content."</td</tr>\n";
    }
    echo <<<EOF
        </tbody>
        </table>
        </div>
EOF
;
    


}
else
{
		
echo <<<EOF
<div class="well">
<form class="form-horizontal" action='answer_search.php' method="GET">
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

}

include 'bottom.php';
?>
