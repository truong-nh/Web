<?php
require_once ('dbhelp.php');
session_start();
$_SESSION['username'] ;
$_SESSION['role'] ;
 $s_username = $s_password = $s_fullname  = $s_email = $s_phone = '';

if (!empty($_POST)) {

    if (isset($_POST['username'])) {
		$s_username = $_POST['username'];
	}
	
    if (isset($_POST['password'])) {
		$s_password = $_POST['password'];
	}
    if (isset($_POST['fullname'])) {
		$s_fullname = $_POST['fullname'];
	}
    if (isset($_POST['email'])) {
		$s_email = $_POST['email'];
	}
    if (isset($_POST['phone'])) {
		$s_phone= $_POST['phone'];
	}
    


	$sql = "update user set fullname = '$s_fullname', email = '$s_email',phone = '$s_phone' where username = '$s_username' ";


	// echo $sql;

	execute($sql);
    if($_SESSION['role']=='teacher'){
	header('Location: home.php');
	die();
	}
	else{
		header('Location: homesv.php');
	die();
	}
}

if (isset($_GET['username'])) {
	$s_username          = $_GET['username'];
	$sql         = "select * from user where username = '$s_username'";
	$studentList = executeResult($sql);
	if ($studentList != null && count($studentList) > 0) {
		$std        = $studentList[0];
        $s_username = $std['username'];
        $s_password = $std['password'];
		$s_fullname = $std['fullname'];
        $s_email = $std['email'];
        $s_phone = $std['phone'];
	} else {
		$s_username = '';
	}
}
else{
	$s_username          = $_SESSION['username'] ;
	$sql         = "select * from user where username = '$s_username'";
	$studentList = executeResult($sql);
	if ($studentList != null && count($studentList) > 0) {
		$std        = $studentList[0];
        $s_username = $std['username'];
        $s_password = $std['password'];
		$s_fullname = $std['fullname'];
        $s_email = $std['email'];
        $s_phone = $std['phone'];
	} else {
		$s_username = '';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registation Form * Form Tutorial</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="panel panel-primary">  
			<div class="panel-heading">
				<h2 class="text-center">Chỉnh sửa thông tin sinh viên</h2>
			</div>
			<div class="panel-body">
				<form method="post">
                    <div class="form-group">
					  <label for="username">Tên đăng nhập:</label>
					  <input readonly="False" type="text" class="form-control" id="username" name="username" value="<?=$s_username?>">
					</div>
                    <div class="form-group">
					  <label for="password">Mật khẩu:</label>
					  <input type="text" class="form-control" id="password" name="password" value="<?=$s_password?>">
					</div>
                    <div class="form-group">
					  <label for="fullname">Họ và tên:</label>
					  <input readonly="False" type="text" class="form-control" id="fullname" name="fullname" value="<?=$s_fullname?>">
					</div>
                    <div class="form-group">
					  <label for="email">Email:</label>
					  <input type="text" class="form-control" id="email" name="email" value="<?=$s_email?>">
					</div>
                    <div class="form-group">
					  <label for="phone">Số điện thoại:</label>
					  <input type="text" class="form-control" id="phone" name="phone" value="<?=$s_phone?>">
					</div>
                    
					<button class="btn btn-success">Chỉnh sửa</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>