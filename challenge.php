<?php
require_once('dbhelp.php');
session_start();
$_SESSION['username'] ;
$s_filename ="";
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
                Danh sách câu đố
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="150px">Tên câu đố</th>
                            <th width="500px">Giáo viên ra đề</th>
                            <th width="300px">mô tả</th>
                            <th width="200px">gợi ý</th>
                            <!-- <th width="150px">trạng thái</th> -->
                            <th width="200px"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 $sql = 'select * from challenge';
 $list =executeResult($sql);
foreach ($list as $std){
         echo' <tr>
         <td>'.$std['name'].'</td>
         <td>'.$std['teacher'].'</td>
         <td>'.$std['description'].'</td>
         <td>'.$std['suggestion'].'</td>

        <td><button onclick="hienThiNhapDapAn('.$std['id'].')">trả lời </button></td>
         </tr>';
}

 ?>

                    </tbody>
                </table>
                <form method="post">
                    <div id="divNhapDapAn" style="display: none;">
                        <label readonly="False" for="dapAn" name="text">Nhập đáp án:</label>
                        <input type="hidden" id="idcaudo" name="id" value="">
                        <input type="text" id="dapAn" name="dapAn">
                        <button type="submit" name="submit">Nộp</button>
                    </div>
                </form>
                <script>
                function hienThiNhapDapAn(id) {
                    // Lấy phần tử div hiển thị
                    var divNhapDapAn = document.getElementById('divNhapDapAn');
                    // Hiển thị div nhập đáp án
                    document.getElementById('idcaudo').value = id;

                    divNhapDapAn.style.display = 'block';
                }
                </script>
            </div>
            <?php

if(isset($_POST['submit'])){
    $dapAn = $_POST['dapAn'];
    $id = $_POST['id'];



	$sql         = "select * from challenge where id = '$id'";

    $messlist =executeResult($sql);
    foreach ($messlist as $std){

             if($std['FileName']==$dapAn or $std['FileName'] ==$dapAn.'.txt' ){

               $thuMuc = 'uploadchallenge/';
               $tenTep = $std['FileName']; 
               
               // Tạo đường dẫn đầy đủ đến tệp
               $duongDanTep = $thuMuc . $tenTep;
               
               // Sử dụng hàm file_get_contents() để đọc nội dung của tệp
               $noiDungTep = file_get_contents($duongDanTep);
               
               // Kiểm tra xem có lỗi khi đọc tệp không
               if ($noiDungTep === false) {
                   echo '<script>alert("Không thể đọc tệp");</script>';
               } else {
                echo '<div class="panel-heading">
                Nội dung câu đố: '.$std['name'].' 
            </div>';
                   echo $noiDungTep;                  
               }


            }
             else{
               echo '<script>alert("Bạn đã trả lời sai");</script>';

             }
    }
}
?>
        </div>

    </div>
</body>

</html>