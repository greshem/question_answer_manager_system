<?php
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];

		$con = mysql_connect("localhost","root","password");
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }

		mysql_select_db("qa_shadow", $con); 

		mysql_query("DELETE FROM answer WHERE a_id = '".$id."'");

		mysql_close($con);
		echo "Success";
	}
?>