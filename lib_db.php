<?php 
class db {

var $conn;
//var $res;
var $db_res;
var $count;
	function connect_db($host, $user, $passwd,$db)
	{
		$this->conn=mysql_connect($host, $user, $passwd) or die("connect error\n");
		if ($this->conn)
		{
			$db_res=mysql_select_db($db, $this->conn);

    mysql_query("set names `utf8` ");  
    mysql_query("set character_set_client=utf8");  
    mysql_query("set character_set_results=utf8"); 

			return $db_res;
		}
		else
		{
			return false;
		}
	}

	function query($query)
	{
		//echo "<h3>$query </h3> <br>";
		$this->db_res=mysql_query($query);

		if(mysql_affected_rows() > 0)
		{
			return $this->db_res;
		}
		else
		{
			return false;
		}
	}

	function  get_q_id_with_question($question)
	{
		$this->query("select *  from  question  where content='$question'");	
		$res=$this->fetch_row();
		#return $res;
		return  $res[0];
	}


	function  get_a_id_with_answer($answer)
	{
		$this->query("select *  from  answer  where content='$answer'");	
		$res=$this->fetch_row();
		#return $res;
		return  $res[0];
	}

	function  get_question_with_q_id($q_id)
	{
		$this->query("select *  from  question  where q_id=$q_id");	
		$res=$this->fetch_row();
		#return $res;
		return  $res[1];
	}


    function  get_q_id_with_answer($question, $q_id)
	{
		$this->query("select *  from  answer  where content='$question' and  parent_q_id='$q_id' ");	
		$res=$this->fetch_row();
		#return $res;
		return  $res[0];
	}


	function  get_answer_count($question)
	{
		$this->query("select count(*)  from  answer   where parent_q_id=$question");	
		$res=$this->fetch_row();
		#return $res;
		return  $res[0];

	}

	function fetch_row()
	{
		$res=mysql_fetch_row($this->db_res);
		return $res;
	}
	function get_count()
	{
		return mysql_affected_rows();
	}

    function get_next_id($id)
    {
        $this->query("select *  from  question  where  q_id >  $id limit 1");	
        $res=$this->fetch_row();
		return  $res[0];
    }


    function get_prev_id($id)
    {
        $this->query("select *  from  question  where  q_id <  $id  order by  q_id  desc  limit 1");	
        $res=$this->fetch_row();
		return  $res[0];
    }


#  update question    set   seg_word='你 喜欢 什么 电影 啊'   where  q_id=1;                   
function  update_q_seg($q_id, $seg)                                                 
{                                                                                              
        if(! is_null($q_id))                                                                   
        {                                                                                      
            $this->query("update  question  set  seg_word='$seg'  where q_id='$q_id' ");       
        }                                                                                      
        return $q_id;                                                                          
}                                                                                              

function  update_q_keywords($q_id, $keywords)               
{                                                                                              
        if(! is_null($q_id))                                                                   
        {                                                                                      
            $this->query("update  question  set  feature_words='$keywords'  where q_id='$q_id' ");                                                                                            
        }                                                                                      
        return $q_id;                                                                          
}                                                      

function  update_a_seg($a_id, $seg)                                                 
{                                                                                              
        if(! is_null($a_id))                                                                   
        {                                                                                      
            $this->query("update  answer  set  seg_word='$seg'  where a_id='$a_id' ");       
        }                                                                                      
        return $a_id;                                                                          
}                                                                                              
function  update_a_keywords($a_id, $keywords)               
{                                                                                              
        if(! is_null($a_id))                                                                   
        {                                                                                      
            $this->query("update  answer  set  feature_words='$keywords'  where a_id='$a_id' ");                                                                                            
        }                                                                                      
        return $a_id;                                                                          
}                                                      


}


?>
