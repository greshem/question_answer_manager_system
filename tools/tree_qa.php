<?php
include("../stat_lib.php");
include "../db_pages.inc.php";

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_db");


$sqldb2=new db;
$sqldb2->connect_db("localhost", "root", "password","qa_db");


$sqldb->query("select * from question   where user!='corechat'  ");
while(list(  $q_id , $content , $user, $create_at  )=$sqldb->fetch_row())
{
    $sqldb2->query("select * from answer where parent_q_id=$q_id " );
    while(list($a_id, $b,$content2 ) =$sqldb2->fetch_row())
    {
        echo  "$q_id|$content| $content2|  $user  \n";
    }
}

?>

