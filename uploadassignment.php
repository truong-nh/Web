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
    $name = $_POST['name'];
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
                $fileDestination = 'uploadassignment/'.$fileNameNew;
                $teacher =$_SESSION['username'] ;
                move_uploaded_file($fileTmpName,$fileDestination);
                $error = true;

                try {
                  $sql = "INSERT INTO assignment ( teacher,NameAssignment,FileDestination) VALUES ('$teacher','$name','$fileDestination')";
                execute($sql);

              } catch (Exception $e) {
               $error = false;
              }

                if ($error) {
                    echo "<script>alert('Thành công');</script>";
                    header ('Location: uploadassignment.php');
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
                    window.open('home.php', '_self');
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
                            <th width="200px"> </th>
                            <th width="200px"> </th>
                            <th width="200px"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 $sql = 'select * from assignment';
 $list =executeResult($sql);
foreach ($list as $std){
         echo' <tr>
         <td>'.$std['NameAssignment'].'</td>
         <td>'.$std['teacher'].'</td>
         <td>'.$std['FileDestination'].'</td>
         <td><button class="btn btn-warning" onclick = window.open("listsubmittedassignment.php?id='.$std['id'].'","_self")>Chi tiết</button></td>
         <td><button class="btn btn-danger" onclick="deleteAssignment('.$std['id'].')">Xóa </button></td>
         <td><a href="'.$std['FileDestination'].'">Tải xuống</a><td>
         </tr>';
}

 ?>

                    </tbody>
                </table>

                <script>
                function deleteAssignment(id) {

                    //Option = confirm ('đồng ý xóa sinh viên '+ username + ' không')
                    Option = confirm('đồng ý xóa câu đố này không')
                    if (!Option) {
                        return
                    }

                    console.log(id);
                    $.post('deleteAssignment.php', {
                        'id': id
                    }, function(data) {
                        alert(data);
                        location.reload();
                    })
                }

                </script>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="assignment" />
                <input type="submit" />

                <div class="form-group">
                    <label for="name">Tên assignment:</label>
                    <input type="text" name="name" value="<?=$name?>">
                </div>
            </form>

        </div>

    </div>
</body>

</html>