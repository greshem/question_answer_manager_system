<?php

include ("lib_db.php");
$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_db");

$sqldb2=new db;
$sqldb2->connect_db("localhost", "root", "password","qa_db");

#$sqldb->query("SELECT answer.*   WHERE     content like '%$keyword%'  ");
# SELECT *   from answer  where  content like "%电影%"
$sqldb->query("SELECT answer.*  from answer   WHERE     content like '%None%'  ");
while(list(  $a_id , $parent_q_id , $content , $user, $create_at, $score,$like_item)=$sqldb->fetch_row())
{
    $question=$sqldb2->get_question_with_q_id($parent_q_id);
    print "q: $question \n"; 
    print "a:".$content."\n";
    print "a_id ".$a_id. "\n";
}
    

?>
