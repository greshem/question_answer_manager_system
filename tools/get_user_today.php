<?php
include ("../lib_db.php");
$sqldb=new db;
$sqldb2=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");
$sqldb2->connect_db("localhost", "root", "password","qa_shadow");

$sqldb->query("select *  from  answer where  to_days(created_at) = to_days(now()) and  user='meiyu' ;  ");	
#最近7天的.
#$sqldb->query(" select * from answer  where   DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(created_at) and user='chenyu'");

while(list($a,$b,$c,$d )= ($sqldb->fetch_row()) )
{
    $question=$sqldb2->get_question_with_q_id($b);
    #print $question."->".$c."\n";
    $question=preg_replace("/小影/i", "小竹子", $question);
    $c=preg_replace("/小影/i", "小竹子", $c);
    echo  <<<EOF
$b| $question |$c

EOF;

}

?>
