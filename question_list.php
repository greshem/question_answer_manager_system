<?php
include 'header.php';
#include 'lib_db.php';
include("stat_lib.php");
include "db_pages.inc.php";

$pagecount=$_GET['pagecount'];
if(! isset($pagecount) )
{
    $pagecount=1;
}
$prev=($pagecount-1);
if($prev<=0) {$prev=1;};
$next= ($pagecount+1);


$keyword=$_GET['keyword'];
$user=$_GET['user'];

if(empty($keyword))
{
    unset($keyword);
}
if(empty($user))
{
    unset($user);
}



$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");

$sqldb2=new db;
$sqldb2->connect_db("localhost", "root", "password","qa_shadow");


function logger($str)
{
    #file_put_contents("all.log", $str,  FILE_APPEND);
}



echo <<<EOF

<script type="text/javascript">
	setTitleActive('que_title');


	function saveEdit(content,id,cTag,obj)
	{
		$.ajax({
			url:'update_question.php?id='+id+'&content='+content,
			type:"GET",
			success: function(data) {
			cTag.innerHTML = content;
			obj.innerText = "编辑";
        }
    });
	}


	function editq(id,obj)
	{
		var cTag = document.getElementById(id);
		if(obj.innerText == "编辑")
		{
			var oriContent = cTag.innerText;
			cTag.innerHTML = "<input type='text' id = 'edit"+id+"' value='"+oriContent+"'/>";
			obj.innerText = "保存";
		}else
		{
			var oriContent = document.getElementById("edit"+id).value;
			saveEdit(oriContent,id,cTag,obj);
		}
	}

</script>

<div class="container-fluid">
      <div class="row-fluid">
    <div class="span2">
      <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">question管理</li>
              <li class="active"><a href="create_question.php">新建Question</a></li>
              <li><a href="question_list.php">Question列表</a></li>
              <li><a href="question_search.php">Question搜索</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
            <div class="btn-toolbar">
                <a class="btn btn-primary" href="create_question.php" >新 建</a>
                <button class="btn" onclick="javascript:window.location.href='question_list.php?pagecount=$prev';">上页</button>
                <button class="btn" onclick="javascript:window.location.href='question_list.php?pagecount=$next';">下页</button>
            </div>


EOF;



$count1= get_all_question_count($sqldb);
$count2= get_all_answer_count($sqldb);
echo <<<EOF
		
<div class="well">
    一共$count1 个问题,   $count2 个答案
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>content</th>
		  <th>creactor</th>
          <th>status </th>
          <th>create_at </th>
          <th style="width: 36px;"></th>
        </tr>
      </thead>
      <tbody>
EOF;


if(isset($keyword) && isset($user))
{
logger("keyword isset and  user isset\n");
logger("SQL: select * from question   where content like '%$keyword%'  and  user='$user' \n");
$sqldb->query("select * from question   where content like '%$keyword%'  and  user='$user';");
$count=$sqldb->get_count();
}
else if(isset($keyword))
{
logger("keyword isset  \n");
logger("select * from question   where content like '%$keyword%'  \n");
$sqldb->query("select * from question   where content like '%$keyword%'  ");
$count=$sqldb->get_count();
}
else if(isset($user))
{
logger("user isset  \n");
logger("select * from question   where user='$user'  \n");
$sqldb->query("select * from question   where user='$user'  ");
$count=$sqldb->get_count();
}
else
{
logger(" keyword and user  all not isset  \n");
logger("select * from question\n");
$sqldb->query("select * from question");
$count=$sqldb->get_count();
}
logger("SQL:count is $count \n");


$onepage=20;
$pb= new AsPagebar($count, $onepage);
$offset = $pb->offset();
$pagebar2=$pb->whole_bar(2,9);
$limit=$offset+$onepage;



#echo ("select * from question limit $offset , $onepage  \n");
if( isset($keyword) && isset($user))
{
logger("SQL:  select * from question  where content  like '%$keyword%'  and user='$user'   limit $offset , $onepage  \n");

$sqldb->query("select * from question  where content  like '%$keyword%'  and user='$user'   limit $offset , $onepage  ");
}
else if(isset($user))
{
$sqldb->query("select * from question  where    user='$user'   limit $offset , $onepage  ");
}
else if(isset($keyword))
{
#$sqldb->query("select * from question  where content  like '%$keyword%'  order  by  answer_count   DESC  limit $offset , $onepage  ");
$sqldb->query("select * from question  where content  like '%$keyword%'    limit $offset , $onepage  ");
}
else
{
#$sqldb->query("select * from question   order  by  answer_count   DESC  limit $offset , $onepage  ");
$sqldb->query("select * from question     limit $offset , $onepage  ");
}

$recordNum = ($pagecount-1)*20 + 1;
//for($i=0; $i<10; $i++)
while(list(  $q_id , $content , $user, $create_at  )=$sqldb->fetch_row())

{

    $count=$sqldb2->get_answer_count($q_id);
	
    echo <<<EOF
       <tr id = "row$q_id">
          <td>$recordNum</td>
          <td id = "$q_id">$content</td>
          <td>$user</td>
          <td> <a href=answer_list.php?q_id=$q_id> 已有$count 个答案 </a> </td>

          <td>$create_at</td>
		  
          <td><a onclick = "editq('$q_id',this)"> 编辑</a> </td>
       </tr> 
EOF;
	$recordNum++;
}

echo <<<EOF
</tbody> 
<div align="left">
$pagebar2
</div>
EOF;

echo <<<EOF
        </div>
    </div>

</div> 

EOF;
include("bottom.php");
?>
