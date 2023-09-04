<?php
if (isset($_POST['username'])) {
	$s_username = $_POST['username'];

	require_once ('dbhelp.php');
	$sql = 'delete from user where username = '.$s_username;
	execute($sql);

	echo 'Xoá sinh viên thành công';
}