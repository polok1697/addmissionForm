<?php
 require_once("./header.php");
$id =  $_GET['id'] ?? header("Location:./");
$id = $conn->real_escape_string($id);
$sql = "SELECT * FROM `students` WHERE `id` = '$id'";
$result = $conn->query($sql);
$result->num_rows == 0 ? header("Location:./") : null;
$obj = $result->fetch_object(); 
if(isset ($_POST['deleteStudents'])){
    $result = $conn->query("DELETE FROM `students` WHERE `id` = '$id'");
    if($result) {
      $delFile = unlink("./uploads/" . $obj->img);
      if($delFile) {
        echo "Student delete successfully";
        echo "<script> setTimeout(()=> location.href='./', 2000) </script>";
      }
       
 } else {
   echo "Student Not deleted";
 }
}

 ?>

<br><br>
<hr>

 

 
 <div class="container form-control">
<form action="" method="post">
<h3>Are you sure! you want to delete this student? </h3>
<input type="submit" value="Yes" name="deleteStudents" class="btn btn-danger">
<a href="./"><button type="button" class="btn btn-primary">NO</button></a>

</form>

</div>

















<?php require_once("./footer.php")?>