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
    print "$content \n";
    $count=$sqldb2->get_answer_count($q_id);
    $sqldb2->query("update  question    set answer_count='$count' where q_id=$q_id;  ");
    $rc= $sqldb2->get_count();
    if($rc==0)
    {
        print("ERROR: $q_id 失效, error \n");
    }
    else
    {
        print ("$q_id 更新 成功\n");
    }
}

?>

