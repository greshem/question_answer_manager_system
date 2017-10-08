<?php
include 'functions.php';

$username =$error= "";

if(isset($_GET['account']))
{
	$username = sanitizeString ( $_GET['account'] );

	if ($username == "") {
		$error = "姓名为空！";
	} else {
		$query = " delete from user where account = '$username'";

		if (mysql_num_rows ( queryMysql ( $query ) ) == 0) {
			$error = "删除失败！";
		} else {
			$error = "删除成功！";
		}
		
		redirect('userlist.php');
	}
}

?>