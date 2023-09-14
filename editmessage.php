<?php
require_once ('dbhelp.php');
session_start();
$_SESSION['username'] ;
$_SESSION['role'] ;
 $s_username = $s_newmess = $s_oldmess = $s_id ='';

if (!empty($_POST)) {

    if (isset($_POST['newmess'])) {
		$s_newmess = $_POST['newmess'];
	}
    if (isset($_POST['id'])) {
		$s_id = $_POST['id'];
	}
	
    


	$sql = "update message set content = '$s_newmess' where id = '$s_id' ";



	execute($sql);
    if($_SESSION['role']=='teacher'){
	header('Location: home.php');
	die();
	}
	else{
		header('Location: listuser.php');
	die();
	}
}

if (isset($_GET['id'])) {
	$s_id          = $_GET['id'];
	$sql         = "select * from message where id = '$s_id'";
	$messList = executeResult($sql);
	if ($messList != null && count($messList) > 0) {
		$std        = $messList[0];
        $s_content = $std['content'];
        $s_receiver = $std['receiver'];
		$s_sender = $std['sender'];

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
				<h2 class="text-center">Chỉnh sửa nội dung</h2>
			</div>
			<div class="panel-body">
				<form method="post">
                    <div class="form-group">
					  <label for="olemess">Tin nhắn cũ:</label>
					  <input readonly="False" type="text" class="form-control" id="olemess" name="olemess" value="<?=$s_content?>">
					</div>
                    <div class="form-group">
					  <label for="newmess">tin nhắn mới:</label>
					  <input type="text" class="form-control" id="newmess" name="newmess" value="<?=$s_content?>">
					</div>
                    <div style="display: none" class="form-group">
					  <label for="newmess">id:</label>
					  <input  type="text" class="form-control" id="id" name="id" value="<?=$s_id?>">
					</div>
                    
					<button class="btn btn-success">Chỉnh sửa</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>