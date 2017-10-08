<?php

	if(isset($_GET["content"]))
	{
		$content = $_GET["content"];
		$id = $_GET["id"];

		$con = mysql_connect("localhost","root","password");
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db("qa_shadow", $con);
		mysql_query("set names `utf8` ");  
		mysql_query("set character_set_client=utf8");  
		mysql_query("set character_set_results=utf8"); 

		mysql_query("UPDATE answer SET content = '".$content."'
		WHERE a_id = '".$id."'");

		mysql_close($con);
		echo "Success";
	}

?>