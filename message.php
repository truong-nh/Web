<?php
session_start();
$_SESSION['username'] ;
require_once ('dbhelp.php');

  $s_receiver = $s_content = $s_sender='';

if (!empty($_POST)) {

    if (isset($_POST['content'])) {
		$s_content = $_POST['content'];
	}
	
    if (isset($_POST['receiver'])) {
		$s_receiver = $_POST['receiver'];
	}
    
    $s_sender = $_SESSION['username'];
    

	$sql = "insert into message(sender, receiver, content, time ) value ('$s_sender','$s_receiver','$s_content', NOW( ))";


	// echo $sql;

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

if (isset($_GET['username'])) {
	$s_receiver          = $_GET['username'];
	$s_sender= $_SESSION['username'];
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
                <button onclick="goBack()">Quay lại</button>
                <script>
                function goBack() {
                    <?php
                    	if($_SESSION['role']=='teacher'){
                            echo 'window.open("home.php", "_self");';
                            }
                            else{
                                echo 'window.open("listuser.php", "_self");';
                            }
                    ?>
                }
                </script>


            </div>
            <div class="panel-heading">
                <h2 class="text-center">Gửi tin nhắn</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="receiver">Username người nhận:</label>
                        <input readonly="False" type="text" class="form-control" id="receiver" name="receiver"
                            value="<?=$s_receiver?>">
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <input type="text" class="form-control" id="content" name="content" value="<?=$s_content?>">
                    </div>


                    <button class="btn btn-success">gửi</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="250px">Thời gian</th>
                            <th width="500px">Nội dung</th>
                            <th width="150px">Người gửi</th>
                            <th width="150px">Người nhân</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
 $sql = "select * from message where (sender = '$s_sender' and receiver ='$s_receiver'  ) or (sender = '$s_receiver' and receiver ='$s_sender'  )";
 $messlist =executeResult($sql);
foreach ($messlist as $std){
         echo' <tr>
		 <td>'.$std['time'].'</td>
		 <td>'.$std['content'].'</td>
         <td>'.$std['sender'].'</td>
         <td>'.$std['receiver'].'</td>';
         if($std['sender']==$_SESSION['username']){
         echo'<td><button class="btn btn-warning" onclick = window.open("editmessage.php?id='.$std['id'].'","_self")>edit</button></td>';         
         echo '<td><button class="btn btn-danger" onclick="deleteMess('.$std['id'].')">Delete</button></td>';
         }
         echo     '</tr>';
}

 ?>

                    </tbody>
                </table>
                <script>
                function deleteMess(id) {

                    Option = confirm('đồng ý xóa tin nhắn này không')
                    if (!Option) {
                        return
                    }

                    console.log(id);
                    $.post('deleteMess.php', {
                        'id': id
                    }, function(data) {
                        alert(data);
                        location.reload();
                    })
                }
                </script>



            </div>

        </div>

    </div>


</body>

</html>