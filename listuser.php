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
                <button onclick="goBack()">Quay lại</button>
                <script>
                function goBack() {
                    window.open('homesv.php', '_self');
                }
                </script>


            </div>
            <div class="panel-heading">
            </div>
            <?php
// Tạo biến session

echo 'tài khoản: ' ;echo $_SESSION['username'];
?>
            <div class="panel-heading">
                Danh sách người dùng
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="150px">Tên đăng nhập</th>
                            <th width="500px">Họ và Tên</th>
                            <th width="300px">Email</th>
                            <th width="100px">Số điện thoại</th>
                            <th width="150px">Vai trò</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 $sql = 'select * from user';
 $studentList =executeResult($sql);
foreach ($studentList as $std){
    
         echo' <tr>
         <td>'.$std['username'].'</td>
         <td>'.$std['fullname'].'</td>
         <td>'.$std['email'].'</td>
         <td>'.$std['phone'].'</td>
         <td>'.$std['role'].'</td>
         <td><button class="btn btn-warning" onclick = window.open("message.php?username='.$std['username'].'","_self")>message</button></td>
               </tr>';
}

 ?>

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>