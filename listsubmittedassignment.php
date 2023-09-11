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
                    window.open('uploadassignment.php', '_self');
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
                            <th width="150px">username</th>
                            <th width="500px">Họ và Tên</th>
                            <th width="300px">Bài nộp</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
 if (isset($_GET['id'])){ 
    $idAssignment=$_GET['id'];
    $sql = "SELECT * FROM submittedassignment, user WHERE submittedassignment.username=user.username and submittedassignment.idAssignment='$idAssignment'";
    
 $list =executeResult($sql);
foreach ($list as $std){
         echo' <tr>
         <td>'.$std['username'].'</td>
         <td>'.$std['fullname'].'</td>

         <td>'.$std['FileDestination'].'</td>
        <td><a href="'.$std['FileDestination'].'">Tải xuống</a>     <td>
        </tr>';
}
 }

 ?>

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>