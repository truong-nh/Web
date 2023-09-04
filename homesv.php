<?php
require_once('dbhelp.php');
session_start();
$_SESSION['username'] ;
?>



<!DOCTYPE html>
<html>

<head>
    <title>Student Management</title>
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
            </div>
            <?php
// Tạo biến session

echo 'tài khoản: ' ;echo $_SESSION['username'];
?>
            <div class="panel-heading">
                Quản lý thông tin sinh viên
            </div>
            <div class="panel-body">
                <button class="btn btn-success" onclick="window.open('edituser.php','_self')"> Chỉnh sửa thông tin cá nhân</button>
                <button class="btn btn-success" onclick="window.open('listuser.php','_self')"> danh sách người dùng</button>
                <button class="btn btn-success" onclick="window.open('adduser.php','_self')"> Bài tập </button>
                <button class="btn btn-success" onclick="window.open('challenge.php','_self')"> Câu đố </button>
            </div>

        </div>

    </div>
</body>

</html>