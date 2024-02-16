<?php
 require_once("./header.php");
 $sql = "SELECT * FROM `students`";
 $result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "No students found";
} else {
    ?>
<hr>
<div class="container">
<h2>Students Informations</h2>
</div>
<hr>
<div class="container">
<table class="table table-hover">
  <thead >
    <tr >
      <th scope="col">Sl</th>
      <th scope="col">Name</th>
      <th scope="col">City</th>
      <th scope="col">e-mail</th>
      <th scope="col">Gender</th>
      <th scope="col">Phone</th>
      <th scope="col">Subject</th>
      <th scope="col">Skills</th>
      <th scope="col">Picture</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php 
  $sn = 1;
  while ($row = $result->fetch_object()){
?>
<tbody>
    <tr >
      <td scope="row"><?=$sn++ ?></th>
      <td><?=$row->name ?></td>
      <td><?=$row->city ?></td>
      <td><?=$row->email ?></td>
      <td><?=$row->gender ?></td>
      <td><?=$row->phone ?></td>
      <td><?=$row->subject ?></td>
      
      <td><?=$row-> skill ?></td>
      <td><img src="./uploads/<?=$row->img ?>" alt="" style= "height : 40px"></td>
      <td>
        <a href="./editStudent.php?id=<?= $row->id?>"><button class="btn btn-warning">Edit</button></a>
        <a href="./deleteStudent.php?id=<?= $row->id?>"><button class="btn btn-danger">Delete</button></a>
      </td>
      
    </tr>
    
  </tbody>

<?php 
}

?>
  
  
  

</table>
</div>
<?php
}

 ?>






<?php require_once("./footer.php")?>
    









