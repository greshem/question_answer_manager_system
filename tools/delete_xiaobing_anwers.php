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
$table="answer";

$result = mysql_query("select  * from   $table   where  content like '%小竹子%'  ");
if(! $result)
{
	die("query error \n");
}



while ($row = mysql_fetch_array($result)) 
#while ($row = mysql_fetch_row($result)) 
{
    #var_dump($row); 
    $id=$row['a_id'];
    #echo "#".$row['a_id']."\t".$row['content']."\n";
    echo "delete  from $table  where  a_id=$id;\n";
}
