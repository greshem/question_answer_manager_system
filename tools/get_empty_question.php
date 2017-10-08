<?php
include("../stat_lib.php");
include "../db_pages.inc.php";

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_db");


$sqldb2=new db;
$sqldb2->connect_db("localhost", "root", "password","qa_db");


$sqldb->query("select * from question    ");
while(list(  $q_id , $content , $user, $create_at  )=$sqldb->fetch_row())
{
    $count=$sqldb2->get_answer_count($q_id);
    if($count==0)
    {
        printf("$q_id,  $content   答案为  $count \n");
    }
}

?>

