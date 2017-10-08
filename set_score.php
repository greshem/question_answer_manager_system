<?php
	if(isset($_GET["q_id"])&&isset($_GET["a_id"])&&isset($_GET["user_id"])&&isset($_GET["like"])&&isset($_GET["cur_like"]))
	{
		$q_id = $_GET["q_id"];
		$a_id = $_GET["a_id"];
		$user_id = $_GET["user_id"];
		$like = $_GET["like"];
		$cur_like = $_GET["cur_like"];

		$con = mysql_connect("localhost","root","password");
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db("qa_shadow", $con);

		if($like == -1)
		{
			mysql_query("INSERT INTO score(q_id,a_id,user_id,like_item) VALUES(".$q_id.",".$a_id.",'".$user_id."',".$cur_like.")");
		}else
		{
			mysql_query("update score  set like_item = ".$cur_like."  WHERE q_id = ".$q_id." AND a_id = '".$a_id."' AND user_id = '".$user_id."'");
		}

		

		mysql_close($con);
        $id=$id+1;
		echo "$id";
	}
?>
