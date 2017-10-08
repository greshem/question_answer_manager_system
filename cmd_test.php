<?php
include ("lib_db.php");

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "qianqian","qa_shadow");

var_dump($sqldb);
#========================================================================
$count=$sqldb->get_answer_count(1);
print "count=$count\n";

print "1 next id ".$sqldb->get_next_id(1)."\n";
print "19 prev id ".$sqldb->get_prev_id(19)."\n";

?>
