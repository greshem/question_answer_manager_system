<?php
#   update question    set   'seg_word'='你 喜欢 什么 电影 啊'   where  q_id=1;

include("lib_db.php");

$sqldb=new db;
$sqldb->connect_db("localhost", "root", "password","qa_db");


$sqldb->update_seg(1, '你 喜欢 什么  电影 呀 ');

?>
