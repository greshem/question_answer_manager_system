<?php

$db_name="qa_shadow";
$db=mysql_connect("localhost", "root", "password") or
die("could not connect");
mysql_select_db( $db_name, $db);

    mysql_query("set names `utf8` ");  
    mysql_query("set character_set_client=utf8");  
    mysql_query("set character_set_results=utf8"); 



#
#("select * from question   where content like '%$keyword%' ");

$db="answer";
#$db="question";
#$result = mysql_query("select  * from   $db   where  content like '%丁丁%'  ");
#$result = mysql_query("select  * from   $db   where  content like '%None%'  ");
$result = mysql_query("select  * from   $db   where  content like '%linux%'  ");
if(! $result)
{
	die("query error \n");
}

while ($row = mysql_fetch_array($result)) 
#while ($row = mysql_fetch_row($result)) 
{
    #var_dump($row); 
    #$id=$row['q_id'];
    $id=$row['a_id'];
    $content=$row['content'];
    #echo "#".$row['a_id']."\t".$row['content']."\n";
    echo "delete  from $db  where  a_id=$id; #$content\n";
}
