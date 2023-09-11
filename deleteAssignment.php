<?php
if (isset($_POST['id'])) {
	$s_id = $_POST['id'];

	require_once ('dbhelp.php');
	$sql = 'delete from assignment where id = '.$s_id;
	execute($sql);

	echo 'Xoá bài tập thành công';
}