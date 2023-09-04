
<?php
session_start();

require_once ('dbhelp.php');
require_once ('config.php');

$connection = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

 $s_username = $s_password ="";

if (!empty($_POST)) {

	if (isset($_POST['username'])) {
		$s_username = $_POST['username'];
    $_SESSION['username']=$_POST['username'];
	}
    if (isset($_POST['password'])) {
		$s_password = $_POST['password'];
	}
   
  $sql = "SELECT * FROM user WHERE username = '$s_username' AND password = '$s_password'";

  $result = mysqli_query($connection, $sql);

  if(isset($_POST['login'])){
      if(mysqli_num_rows($result) === 1){
          while ($row = $result -> fetch_assoc()) {
              $_SESSION['username'] = $row['username'];
              $_SESSION['password'] = $row['password'];
              $_SESSION['role'] = $row['role'];
              $_SESSION['fullname'] = $row['fullname'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['phone'] = $row['phone'];
              $_SESSION['is_login'] = true;
  
  
              if( $_SESSION['role'] == 'teacher'){
              header('Location: home.php');
              }
              else{
                header('Location: homesv.php');
              }
          }
      }
      else{
          header("location:login.php");
      }
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
				<h2 class="text-center">Đăng nhập</h2>
			</div>
			<div class="panel-body">
				<form method="post">
                    <div class="form-group">
					  <label for="username">Tên đăng nhập:</label>
					  <input type="text" class="form-control" id="username" name="username" value="<?=$s_username?>">
					</div>
                    <div class="form-group">
					  <label for="password">Mật khẩu:</label>
					  <input type="text" class="form-control" id="password" name="password" value="<?=$s_password?>">
					</div>
                    
					<button class="btn btn-success" name=login>Đăng nhập</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>