<?php
include("../stat_lib.php");
include "../db_pages.inc.php";

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_shadow");


$sqldb2=new db;
$sqldb2->connect_db("localhost", "root", "password","qa_shadow");


$sqldb->query("select * from answer    ");
while(list(  $a_id , $q_parent_id, $content , $user, $create_at  )=$sqldb->fetch_row())
{
    $count=$sqldb2->question_exists($q_parent_id);
    if($count==0)
    {
        printf(" |$content| $a_id  问题不存在   \n");
        printf("delete from answer  where  parent_q_id=$q_parent_id;\n");
    }
}

?>

