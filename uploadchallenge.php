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
    $suggestion = $_POST['suggestion'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $file = $_FILES['challenge'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('txt');
    if (in_array($fileActualExt,$allowed)){
        if ($fileError === 0){
            if ($fileSize < 50000000){
                //$fileNameNew = md5($fileName).'.'.$fileActualExt;
                $fileDestination = 'uploadchallenge/'.$fileName;
                $teacher =$_SESSION['username'] ;
                move_uploaded_file($fileTmpName,$fileDestination);
                $error = true;

                try {
                  $sql = "INSERT INTO challenge (name, teacher,description,filedestination,filename,suggestion) VALUES ('$name','$teacher','$description','$fileDestination','$fileName','$suggestion')";
                execute($sql);

              } catch (Exception $e) {
               $error = false;
              }

                if ($error) {
                    echo "<script>alert('Thành công');</script>";
                    header ('Location: home.php');
                }
                else {
                    echo "<script>alert('không thể thêm câu đố vào cơ sở dữ liệu);</script>";
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
        echo "<script>alert('Chỉ upload file txt');</script>";
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
         <td><button class="btn btn-danger" onclick="deleteChallenge('.$std['id'].')">Delete</button></td>
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
                function deleteChallenge(id) {

                    //Option = confirm ('đồng ý xóa sinh viên '+ username + ' không')
                    Option = confirm('đồng ý xóa câu đố này không')
                    if (!Option) {
                        return
                    }

                    console.log(id);
                    $.post('deleteChallenge.php', {
                        'id': id
                    }, function(data) {
                        alert(data);
                        location.reload();
                    })
                }
                </script>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="challenge" />
                <input type="submit" />

                <div class="form-group">
                    <label for="name">Tên challenge:</label>
                    <input type="text" name="name" value="<?=$name?>">
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <input type="text" name="description" value="<?=$description?>">
                </div>
                <div class="form-group">
                    <label for="suggestion">Gợi ý:</label>
                    <input type="text" name="suggestion" value="<?=$suggestion?>">
                </div>
            </form>
        </div>

    </div>
</body>

</html>