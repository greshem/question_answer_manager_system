<?php
ob_start();
session_start();

?>
<html>

<head>
<meta contentType="text/html" charset="utf8">
</head>
<?php

function logger($str)
{
    #file_put_contents("all.log", $str,  FILE_APPEND);
}



require_once("lib_db.php");
require_once("update_seg_keywords_all.php");

if ( isset($_POST['user'])) 
{ 
        $_SESSION['user']=$_POST['user'];
}

if (! isset($_SESSION['user']) ) 
{
    $_SESSION['user']="nobody";
}
else
{

    if ( isset($_POST['user'])) 
    { 
        $_SESSION['user']=$_POST['user'];
    }
}


date_default_timezone_set('Asia/Shanghai'); 

$q_id=$_POST['q_id'];
$redir_url;


$question=trim($_POST['question']);
$answer=trim($_POST['answer']);
$batch_import=trim($_POST['batch_import']);  #批量导入模式, 不做分词 太慢了.

if(empty($batch_import))
{
    unset($batch_import);
}

#print "anaser=|$answer|<br>";

function  append_answer($sqldb, $answer, $q_id)
{
        global  $redir_url;
        $a_id=null;
        #check answer 有效.
		if(! is_null($answer) && isset($answer)   &&  strlen($answer) > 0  )  
		{
            #qa对是否存在.
            $a_id=$sqldb->get_q_id_with_answer($answer, $q_id)	;
			if(! is_null($answer))
			{
                #qa对存在, 一般机率很小..
                if(! is_null( $a_id))
                {
                    #logger("question $q_id  对应的: $answer  已经存在了\n");
                    return $a_id;
                }
                $user= $_SESSION['user'];
				$sqldb->query("insert  INTO  answer  (`a_id`, `parent_q_id`, `content`, `user`)   values( NULL, $q_id,  '$answer', '$user' )  ");
			    $a_id=mysql_insert_id();

                #$redir_url="answer_list.php?q_id=$q_id";
			}
		}
		else
		{
			echo "answer  为空<br>";
            $redir_url="answer_list.php?q_id=$q_id";
		}
        return  $a_id;
}

function  insert_question($sqldb, $question)
{
		$q_id=$sqldb->get_q_id_with_question($question)	;
		if(is_null($q_id))
		{
            $user= $_SESSION['user'];
			$sqldb->query("insert  INTO  question  (`q_id`, `content`, `user`)   values( NULL,   '$question' , '$user') ");
			$q_id=mysql_insert_id();
			print "创建新的q_id =  $q_id <br>";
            $redir_url="answer_list.php?q_id=$q_id";

			#assert($q_id != NULL);
		}
		else
		{
			#print "问题已经存在, 不创建新的 question id <br>";
		}
        return $q_id;

}

$redir_url=null;
if($q_id != "-100")
{	
	$old_q_id = $q_id;
	if(! is_null($question)  && isset($question) )
	{	
		echo " q_id 为空 ,  添加 question 记录.<br>";
		$sqldb=new db;
		$sqldb->connect_db("localhost","root","password", "qa_shadow");
        $q_id=insert_question($sqldb,  $question);

        if(is_null($batch_import))
        {
        logger("   现在 不是 batch import  模式 \n");
        $output=seg_str($question);
        update_question_seg_keyword_qid($sqldb, $q_id,$output);
        }

        if(isset($_POST["answer"])) 
        {
            $tmp=$_POST["answer"];
            $a_id=append_answer($sqldb, $tmp, $q_id);
            if(!is_null($a_id) &&  is_null($batch_import))
            {
            $output=seg_str($tmp);
            update_answer_seg_keyword_aid($sqldb, $a_id,$output);
            }
        }
        if(isset($_POST["answer1"]) )
        {
            $tmp=$_POST["answer1"];
            $a_id=append_answer($sqldb, $tmp, $q_id);
            if(!is_null($a_id)    && is_null($batch_import)  )
            {
            $output=seg_str($tmp);
            update_answer_seg_keyword_aid($sqldb, $a_id,$output);
            }
        }
        if(isset($_POST["answer2"]) )
        {
            $tmp=$_POST["answer2"];
            $a_id=append_answer($sqldb, $tmp, $q_id);
            if(!is_null($a_id) && is_null($batch_import)   )
            {
            $output=seg_str($tmp);
            update_answer_seg_keyword_aid($sqldb, $a_id,$output);
            }
        }

        if(isset($_POST["answer3"])) 
        {
            $tmp=$_POST["answer3"];
            $a_id=append_answer($sqldb, $tmp, $q_id);
            if(!is_null($a_id)  && is_null($batch_import)   )
            {
            $output=seg_str($tmp);
            update_answer_seg_keyword_aid($sqldb, $a_id,$output);
            }


        }
        if(isset($_POST["answer4"]))
        {
            $tmp=$_POST["answer4"];
            $a_id=append_answer($sqldb, $tmp, $q_id);
            if(!is_null($a_id)  && is_null($batch_import)   )
            {
            $output=seg_str($tmp);
            update_answer_seg_keyword_aid($sqldb, $a_id,$output);
            }


        }
        //$redir_url="answer_list.php?q_id=$q_id";
		if($old_q_id == "")
		{
			echo "新问题<br>";
			$redir_url="create_question.php";
		}else
		{
			echo "老问题<br>";
			$redir_url="answer_list.php?q_id=$q_id";
		}
		
	}
	else
	{
		echo "question 为空<br>";
        $redir_url="create_question.php?submit_state=false";
	}
}
else
{
	echo " q_id 不为空 ,  修改 question 记录.<br>";
	$sqldb=new db;
	$sqldb->connect_db("localhost","root","password", "qa_shadow");
	//$sqldb->query("select * from question where    and q_id=$q_id    and content=$content   ");
	$sqldb->query("select * from  question where q_id=$q_id");

	if($sqldb->fetch_row())
	{
		$sqldb->query("update question set  
					q_id='$q_id'      
				,	content='$content'       
					where q_id=$q_id ");
		echo "update  result=\n";
		echo mysql_error(),"<br>";

        if(isset($_POST["answer"])) 
        {
            $tmp=$_POST["answer"];
            append_answer($sqldb, $tmp, $q_id);
        }
        if(isset($_POST["answer1"]))
        {
            $tmp=$_POST["answer1"];
            append_answer($sqldb, $tmp, $q_id);
        }
        if(isset($_POST["answer2"]))
        {
            $tmp=$_POST["answer2"];
            append_answer($sqldb, $tmp, $q_id);
        }
        if(isset($_POST["answer3"]))
        {
            $tmp=$_POST["answer3"];
            append_answer($sqldb, $tmp, $q_id);
        }
        if(isset($_POST["answer4"]))
        {
            $tmp=$_POST["answer4"];
            append_answer($sqldb, $tmp, $q_id);
        }
	
        $redir_url="answer_list.php?q_id=$q_id";

	}
	else
	{
		echo "question id $q_id not  exists \n";
		echo mysql_error(),"\n";
	}

}


?>


<table width="50%" border="0" cellspacing="1" cellpadding=3 align="center"> 
	<tr><td><a href="index.php"> qa列表  </a> </td></tr>
</table>
	<table width="50%" border="1" cellspacing="1" cellpadding="3" align="center">
	<tr><td><a href=question_modify.php?q_id=<?php echo $q_id?> > 修改 </a> </td><td> ____ </td></tr>	
    

    <tr><td width="24%"> q_id </td> 
		<td width="76%"> 
		<?php echo 	$q_id   ?>
		</td>
    </tr>
    <tr><td width="24%"> content </td> 
		<td width="76%"> 
		<?php echo 	$question   ?>
		</td>
    </tr>
    <tr><td width="24%"> answer </td> 
		<td width="76%"> 
		<?php echo 	$answer   ?>
		</td>
    </tr>


  </table>
<?php
header("Location: $redir_url");
echo "<a href=$redir_url> 重定向地址 </a><br>" ;
echo "<a href=question_modify.php?q_id=$q_id> 再回答 </a><br>" ;
echo "<a href=answer_list.php?q_id=$q_id> 本问题列表 </a><br>" ;
?>

</html>
