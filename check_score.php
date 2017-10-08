<?php

	if(isset($_GET["q_id"])&&isset($_GET["a_id"])&&isset($_GET["user_id"]))
	{
		$q_id = $_GET["q_id"];
		$a_id = $_GET["a_id"];
		$user_id = $_GET["user_id"];
		$out = -1;

		$con = mysql_connect("localhost","root","password");
		if (!$con)
		{
		  die('Could not connect: ' . mysql_error());
		}

		mysql_select_db("qa_shadow", $con);

		$result = mysql_query("SELECT 'like_item' FROM score WHERE q_id = '".$q_id."' and a_id = '".$a_id."' and user_id = '".$user_id."'");
		if($row = mysql_fetch_array($result))
		{
			$out = $row['like_item'];
		}

		mysql_close($con);
		echo $out;
	}

?>