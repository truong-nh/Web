<?php
session_start();
$_SESSION['username'] ;
require_once ('dbhelp.php');
if (!(isset($_SESSION['is_login']) && $_SESSION['is_login'] == true)) {
    header('Location: login.php');
    exit();
}
$suggestion = $name = $description  = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['nameAssignment'];
    $username =$_SESSION['username'];
    $id = $_POST['id'];
    $file = $_FILES['assignment'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg','jpeg','png','gif','pdf','docx','zip','rar','txt','7z');
    if (in_array($fileActualExt,$allowed)){
        if ($fileError === 0){
            if ($fileSize < 50000000){
                $fileNameNew = $name.'_'.$fileName;
                $fileDestination = 'upload_submit_assignment/'.$fileNameNew;
                $teacher =$_SESSION['username'] ;
                move_uploaded_file($fileTmpName,$fileDestination);
                $error = true;
                 
                try {
                    $result=executeResult("select * from submittedassignment where idAssignment='$id' and username='$username' ");
                if($result==null){
                  $sql = "INSERT INTO submittedassignment ( idAssignment,username,FileDestination) VALUES ('$id','$username','$fileDestination')";
                execute($sql);
                }
                else{
                    $sql = "UPDATE submittedassignment Set FileDestination = '$fileDestination' WHERE idAssignment ='$id' and username ='$username'";
                    execute($sql);
                }

              } catch (Exception $e) {
               $error = false;
              }

                if ($error) {
                    echo "<script>alert('Thành công');</script>";
                    header ('Location: homesv.php');
                }
                else {
                    echo "<script>alert('không thể thêm bài tập vào cơ sở dữ liệu);</script>";
                }
            }
            else {
                echo "<script>alert('kích thước file quá lớn');</script>";
            }
        }
        else {
            echo "<script>alert('không thể tải file lên);</script>";
        }
    }
    else {
        echo "<script>alert('Loại file không hợp lệ:'jpg','jpeg','png','gif','pdf','docx','zip','rar','txt','7z' ');</script>";
    }
}
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
                            <th width="150px">Tên bài tập</th>
                            <th width="500px">Giáo viên ra đề</th>
                            <th width="300px">Đề bài</th>
                            <!-- <th width="150px">trạng thái</th> -->
                            <th width="200px">Nộp bài</th>
                            <th width="200px">Bài nộp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 $sql = 'select * from assignment';
 $list =executeResult($sql);
foreach ($list as $std){
    $username=$_SESSION['username'];
         echo' <tr>
         <td>'.$std['NameAssignment'].'</td>
         <td>'.$std['teacher'].'</td>
         <td><a href="'.$std['FileDestination'].'">Tải xuống</a><td>
         <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="assignment" />
                <input type="hidden" id="id" name="id" value="'.$std['id'].'">
                <input type="hidden" id="nameAssignment" name="nameAssignment" value="'.$std['NameAssignment'].'">
                <input type="submit" />
            </form>
         ';
         $id= $std['id'];
         $query1 =$result=executeResult("select * from SubmittedAssignment where IdAssignment = '$id' and username='$username' ");
         if($result!=null){
            foreach ($query1 as $std1){
                echo '<td><a href="'.$std1['FileDestination'].'">Tải xuống</a><td>'  ;
                break;
             }
          }
         
         echo '</tr>';
}



 ?>

                    </tbody>
                </table>
            </div>



        </div>

    </div>
</body>

</html>