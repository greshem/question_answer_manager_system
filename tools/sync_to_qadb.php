<?php
include ("../lib_db.php");
$sqldb=new db;
$sqldb2=new db;
$sqldb->connect_db("localhost", "root", "password","qa_db");
$sqldb2->connect_db("localhost", "root", "password","qa_db");
#$sqldb->query("select *  from  answer where  to_days(created_at) = to_days(now());  ");	
$sqldb->query("select *  from  answer where  user='haitian';  ");	

while(list($a,$b,$c,$d )= ($sqldb->fetch_row()) )
{
    $question=$sqldb2->get_question_with_q_id($b);
    #print $question."->".$c."\n";
    $question=preg_replace("/小影/i", "小竹子", $question);
    $c=preg_replace("/小影/i", "小竹子", $c);

    echo  <<<EOF
wget --post-data="question=$question&answer=$c&user=$d&batch_import=yes"  http://192.168.1.11/qa_shadow_dev/question_modifyok.php 

EOF;

}

?>
