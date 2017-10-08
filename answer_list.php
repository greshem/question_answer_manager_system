<?php
include 'header.php';

include ("lib_db.php");
$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");
$cur_user = $_SESSION['user'];

$q_id= $_GET['q_id'];
$keyword= $_GET['keyword'];
$sqldb->query("select * from  question  where  q_id=$q_id;");
$res=$sqldb->fetch_row();
$question=$res[1];

#get_next_id($id)
#get_prev_id($id)

$next_id= $sqldb->get_next_id($q_id);
$prev_id= $sqldb->get_prev_id($q_id);

echo <<<EOF
<script type="text/javascript">
	
	function keyevent(){ 
		if(event.keyCode==13)
			window.location.href='create_question.php?q_id=$q_id';
		if(event.keyCode==37)
			window.location.href='answer_list.php?q_id=$prev_id';
		if(event.keyCode==39)
			window.location.href='answer_list.php?q_id=$next_id';
	} 
	document.onkeydown = keyevent; 
	setTitleActive('ans_title');

	function del(id) 
	{  
		if(window.confirm('你确定要删除该记录！'))
		{
			$.ajax({
			url:'delete_answer.php?id='+id,
			type:"GET",
			success: function(data) {
					//alert('成功');
					var currentRow = document.getElementById('row'+id);
					currentRow.remove(currentRow.selectedIndex);
				}
			});
		 }
	}

	//-1:null 0:dislike 1:like
	function checkScore(q_id,a_id,user_id)
	{
		$.ajax({
			url:'check_score.php',
			type:"GET",
			success: function(data) {
				alert("chenggong");
			}
		});
	}

	function saveEdit(content,id,cTag,obj)
	{
		$.ajax({
			url:'update_anwser.php?id='+id+'&content='+content,
			type:"GET",
			success: function(data) {
			cTag.innerHTML = content;
			obj.innerText = "编辑";
			}
		});
	}

	//-1:null 0:dislike 1:like
	function set_score(q_id,a_id,user_id,cur_like)
    {
		var like = -1;
		var add_tag = "#add_score"+a_id;
		var reduce_tag = "#reduce_score"+a_id;
		var tu_tag = "#tu"+a_id;
		var td_tag = "#td"+a_id;

		var reduce_state = $(reduce_tag).attr("disabled");
		var add_state = $(add_tag).attr("disabled");

		if(reduce_state||add_state)
		{
			like = 2;
		}else
		{
			like = -1;
		}

		if(like == '')
		{
			like = -1;
		}
		//alert('qid:'+q_id+'  aid:'+a_id+'  userid:'+user_id+'  like:'+like+'  cur_like:'+cur_like);
		$.ajax({
			url:'set_score.php?q_id='+q_id+'&a_id='+a_id+'&user_id='+user_id+'&like='+like+'&cur_like='+cur_like,
			type:"GET",
			success: function(data) {
					if(cur_like == 0)
					{
						$(reduce_tag).attr("disabled", true);
						$(td_tag).attr("style","background-color:#f00");
						$(add_tag).attr("disabled", false);
						$(tu_tag).attr("style","");
					}else
					{
						
						$(add_tag).attr("disabled", true);
						$(td_tag).attr("style","");
						$(reduce_tag).attr("disabled", false);
						$(tu_tag).attr("style","background-color:#0f0");
					}
				}
			});


    }

	function edita(id,obj)
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
              <li class="nav-header">answer管理</li>
              <li class="active"><a href="create_question.php?q_id=$q_id">新建Answer</a></li>
              <li><a href="answer_list.php?q_id=$q_id">Answer列表</a></li>             
             <li><a href="answer_search.php">answer搜索</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <div class="span10">
            <div class="btn-toolbar">
                <a class="btn btn-primary" href="create_question.php?q_id=$q_id" >添加回答</a>
                <button class="btn" onclick="javascript:window.location.href='answer_list.php?q_id=$prev_id';">上一个</button>
                <button class="btn" onclick="javascript:window.location.href='answer_list.php?q_id=$next_id';">下一个</button>
            </div>
        <h3>$question</h3> 
EOF;

//window.location.href('answer_list.php?q_id=$next_id')
echo <<<EOF
		
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
		  <th>score</th>
          <th>content</th>
		  <th>creator</th>
          <th>created_at </th>
          <th style="width: 36px;"></th>
        </tr>
      </thead>
      <tbody>
EOF;


#$sqldb->query("select * from answer  where parent_q_id=$q_id   ORDER BY a_id DESC ");
if(!isset($keyword))
{
$sqldb->query("SELECT answer.*,score.like_item FROM answer LEFT JOIN score ON score.q_id = answer.parent_q_id AND score.a_id = answer.a_id AND score.user_id = '$cur_user' WHERE answer.parent_q_id=$q_id");
}
else
{
$sqldb->query("SELECT answer.*,score.like_item FROM answer LEFT JOIN score ON score.q_id = answer.parent_q_id AND score.a_id = answer.a_id AND score.user_id = '$cur_user' WHERE answer.parent_q_id=$q_id and    content like '%$keyword%'  ");
}

$count=$sqldb->get_count();
echo "一共$count 条记录<br>";
$count=0;
$recordNum = 0;
while(list(  $a_id , $parent_q_id , $content , $user, $create_at, $score,$like_item)=$sqldb->fetch_row())
{
	$recordNum++;
	$addScoreAble = "";
	$reduceScoreAble = "";
	$tuColor = "";
	$tdColor = "";

		

	switch($like_item)
	{
		case '0':
			$reduceScoreAble = "disabled='' ";
			$tdColor= "style='background-color:#f00'";
			break;
		
		case '1':
			$addScoreAble = "disabled=''";
			$tuColor="style='background-color:#0f0'";
			break;

		default:
			break;
	}
	
	echo "
		
		<tr  id = row".$a_id.">
				<td>".$recordNum."</td> 
				<td id=score".$a_id.">   
				<button id=add_score".$a_id." class=btn  ".$addScoreAble." onclick='set_score(\"".$q_id."\",\"".$a_id."\",\"".$cur_user."\",\"1\")' ><i ".$tuColor." id = tu".$a_id." class='fa fa-thumbs-o-up'></i></button> 
				<button id=reduce_score".$a_id." class=btn ".$reduceScoreAble." onclick='set_score(\"".$q_id."\",\"".$a_id."\",\"".$cur_user."\",\"0\")'><i ".$tdColor." id = td".$a_id." class='fa fa-thumbs-o-down'></i></button>
				</td> 
				<td id = ".$a_id.">".$content."</td>  
				<td>".$user."</td> 
				<td>".$create_at."</td> 
				
				<td><a onclick = 'del(\"".$a_id."\")'>删除</a> </td>
				<td><a onclick = 'edita(\"".$a_id."\",this)'>编辑</a> </td> 
        <tr>";
	$count++;
}

echo "</table>";

if(!isset($q_id))
{
    echo "<hr> <div> <h2> q_id 为空<h2></div> \n";
}

echo <<<EOF
        </div>  <!--/well-->

    </div>  <!--/span10-->


</div> 

EOF;
include 'bottom.php';
?>
