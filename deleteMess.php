<?php
if (isset($_POST['id'])) {
	$s_id = $_POST['id'];

	require_once ('dbhelp.php');
	$sql = 'delete from message where id = '.$s_id;
	execute($sql);

	echo 'Xoá tin nhắn thành công';
}