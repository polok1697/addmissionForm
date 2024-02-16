<?php
 require_once("./header.php");
 $id =  $_GET['id'] ?? header ("location:./");
 $id = $conn->real_escape_string($id);
 $sql = "SELECT * FROM `students` WHERE `id` = '$id'";
 $result = $conn->query($sql);
 $result->num_rows  == 0 ? header ("location:./") : null ; 
 $row = $result->fetch_object();
 if (isset($_POST['editStudent'])) {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $subject = $_POST['subject'];
    $skills = $_POST['skills'] ?? [];
    $skillsStr = implode(", ", $skills);


    $name= $conn->real_escape_string($name);
    $city= $conn->real_escape_string($city);

     
    $result = $conn->query("UPDATE `students` SET `name` = '$name', `city`='$city' , `email`='$email', `phone`='$phone', `gender`='$gender', `subject`='$subject', `skill`='$skillsStr'  WHERE `id` = '$id'");
    if ($result) { 
        echo "Student updated successfully";
        echo "<script> setTimeout(()=> location.href='./', 2000) </script>";
 } else {
   echo "Student Not Updated";
 }
}


if (isset($_POST['editStudentPic'])) {
    $pic = $_FILES['pic'];
    $picName = $pic['name'];
    $picTmpName = $pic['tmp_name'];
    $picSize = $pic['size'];
    $picError = $pic['error'];
    $picType = $pic['type'];

    $picExt = explode('.', $picName);
    $picActualExt = strtolower(end($picExt));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($picActualExt, $allowed)) {
        if ($picError === 0) {
            if ($picSize < 10000000) {
                $picNameNew = uniqid('', true) . "." . $picActualExt;
                $picDestination = "./uploads/" . $picNameNew;
                $move = move_uploaded_file($picTmpName, $picDestination);
                if ($move) {
                    $result = $conn->query("UPDATE `students` SET `img`='$picNameNew' WHERE `id`= $id");
                    if ($result) {
                        $delFile = unlink("./uploads/" . $row->img);
                        if ($delFile) {
                            echo "Student Updated Successfully";
                            echo "<script>setTimeout(()=> location.href='./', 2000)</script>";
                        }
                    } else {
                        echo "Student Not Updated";
                    }
                } else {
                    echo "File Not Uploaded";
                }
            } else {
                echo "Your file is too big";
            }
        } else {
            echo "There was an error uploading your file";
        }
    } else {
        echo "You cannot upload files of this type";
    }
}

 ?>




<div class="container form-control align-item-center col-8">
    <h2>Students Update Form</h2>
 </div>
<hr>

<div class="container form-control">
<form action="" method="post" enctype="multipart/form-data" >
        <input type="text" placeholder="Student Name" name="name"  value="<?= $row->name?>" class=" form-control">
        <br><br>
        <input type="text" placeholder="City" name="city" value="<?= $row->city?>" class=" form-control">
        
              
        <br>
        <input type="email" placeholder="email" name="email" class=" form-control" value="<?= $row->email?>">
        <br>
        <input type="number" placeholder="phone" name="phone" class=" form-control" value="<?= $row->phone?>">
        
        <br>
     
        Gender:
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="inlineCheckbox1" name="gender" value="Male"  <?= $row->gender == "Male" ? "checked" : null?>>
            <label class="form-check-label" for="inlineCheckbox1">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="inlineCheckbox2"  name="gender" value="Female" <?= $row->gender == "Female" ? "checked" : null?>>
            <label class="form-check-label" for="inlineCheckbox2">Female</label>
        </div>



       
        <br><br>
        Subject:
        <select class="form-select mt-2" aria-label="Default select example" name="subject" required>
            <option selected>Open this select menu</option>
            <option value="PHP" <?= $row->subject == "PHP" ? "selected" : null?>>PHP</option>
            <option value="Python"<?= $row->subject == "Python" ? "selected" : null?>>Python</option>
            <option value="Java"<?= $row->subject == "Java" ? "selected" : null?>>Java</option>
        </select>
        
        
        <br>
        Skills :
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="skills[]" value="PHP" <?= isset($skills) && in_array("PHP", $skills) ? "checked" : (!isset($skills) &&  in_array("PHP", explode(", ", $row->skill )) ? "checked" : null) ?>>
            <label class="form-check-label" for="inlineCheckbox1">PHP</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="skills[]" value="Python" <?= isset($skills) && in_array("Python", $skills) ? "checked" : (!isset($skills) && in_array("Python", explode(", ", $row->skill )) ? "checked" : null) ?>>
            <label class="form-check-label" for="inlineCheckbox2">Python</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="skills[]" value="Java" 
            
            <?php 
                if ( isset($skills) && in_array("Java", $skills)){ 
                    echo "checked=" ;
                } elseif (!isset($skills) &&  in_array("Java", explode(", ", $row->skill ))) {
                echo "checked" ; 
                }
            ?>>

            <label class="form-check-label" for="inlineCheckbox2">Java</label>
        </div>


        <br><br>
       


    
    
        <br><br>
        <input type="submit" value="Update Student" name="editStudent" class="btn btn-primary">
    </form>
<br><br><br>
    


<label for="getPic">
    <img src="./uploads/<?= $row->img ?>" alt="" width="150" id="showImg">
</label>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="pic" id="getPic" style="display: none;">
    <br><br>
    <input type="submit" value="Change image" name="editStudentPic" class="btn btn-primary">
</form>



<script>
    const getPic = document.querySelector('#getPic');
    const showImg = document.querySelector('#showImg');
    getPic.addEventListener('change', () => {
        const [file] = getPic.files;
        if (file) {
            showImg.src = URL.createObjectURL(file);
        }
    })
</script>
<br><br><br><br><br>










<?php require_once("./footer.php")?>