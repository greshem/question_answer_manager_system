<?php

include ("lib_db.php");

function get_all_question_count($sqldb)
{
    $sqldb->query("select count(*)  from  question  ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}

function get_all_answer_count($sqldb)
{
    $sqldb->query("select count(*)  from  answer  ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}

function   get_today_active_uers($sqldb)
{
    #where to_days(created_at) = to_days(now());"
    $sqldb->query("select  distinct user   from  question where to_days(created_at) = to_days(now()); ");	

    $name_lists=array();
    while(list(  $name )= ($sqldb->fetch_row()) )
    {
        array_push($name_lists, $name);
    }
    return  $name_lists;
}

function get_users($sqldb)
{
    $sqldb->query("select  distinct user   from  question ");	

    $name_lists=array();
    while(list(  $name )= ($sqldb->fetch_row()) )
    {
        array_push($name_lists, $name);
    }
    return  $name_lists;
}

function get_users_question_count($sqldb, $user)
{
    $sqldb->query("select count(*)  from  question where user='$user' ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}

function get_today_users_question_count($sqldb, $user)
{
    $sqldb->query("select count(*)  from  question where user='$user' and  to_days(created_at) = to_days(now());  ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}


function get_today_users_answer_count($sqldb, $user)
{
    $sqldb->query("select count(*)  from  answer where user='$user' and  to_days(created_at) = to_days(now());  ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}


function get_users_answer_count($sqldb, $user)
{
    $sqldb->query("select count(*)  from  answer where user='$user' ");	
    list($count)=$sqldb->fetch_row();
    return $count;
}

function get_today_question($sqldb)
{
    #select * from  question where to_days(created_at) = to_days(now()); 
    $sqldb->query(" select  count(*) from  question where to_days(created_at) = to_days(now());");	
    list($count)=$sqldb->fetch_row();
    return $count;
}


function get_today_answer($sqldb)
{
    #select * from  question where to_days(created_at) = to_days(now()); 
    $sqldb->query(" select  count(*) from  answer where to_days(created_at) = to_days(now());");	
    list($count)=$sqldb->fetch_row();
    return $count;
}

function	array_to_str($value)
{
	$ret_str;
	foreach($value as $key=>$value)
	{
	    $ret_str.="&nbsp&nbsp&nbsp&nbsp  <a href=# > $value </a> <br>";
	}
	return $ret_str;
}


function test_unit()
{
    $sqldb=new db;
    $sqldb->connect_db("localhost", "root", "password","qa_shadow");
    //########################################################################
    $users=get_users($sqldb);
    foreach ($users as $key=>$value) {
        print "#========================================================================\n";
        print "用户名:  |$value|\n";
        $count=get_users_question_count($sqldb, $value);
        print "输入question总数:  count=$count\n";

        $count=get_users_answer_count($sqldb, $value);
        print "输入answer总数:  count=$count\n";


    }

    $count=get_today_question($sqldb);
    print "#今天输入 $count 个问题\n";
    $count=get_today_answer($sqldb);
    print "#今天输入 $count 个答案\n";
}

