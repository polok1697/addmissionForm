<?php
require_once("./header.php");
if (isset($_POST['ast'])) {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pic = $_FILES['pic'];
    $picName = $pic['name'];
    $picTmpName = $pic['tmp_name'];
    $picSize = $pic['size'];
    $picError = $pic['error'];
    $picType = $pic['type'];
    $gender = $_POST['gender'];
    $subject = $_POST['subject'];
    $skills = $_POST['skills'] ?? [];
    $skillsStr = implode(", ", $skills);

    $picExt = explode('.', $picName);
    $picActualExt = strtolower(end($picExt));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    $checkNameQuery = $conn->query("SELECT * FROM `students` WHERE `name` = '$name'");

    if ($checkNameQuery->num_rows > 0) {
        echo "Student Already Exists";
        echo "<script>setTimeout(()=> location.href='./', 2000)</script>";
        exit;
    } else {
        if (in_array($picActualExt, $allowed)) {
            if ($picError === 0) {
                if ($picSize < 10000000) {
                    $picNameNew = uniqid('', true) . "." . $picActualExt;
                    $picDestination = "./uploads/" . $picNameNew;
                    $move = move_uploaded_file($picTmpName, $picDestination);
                    if ($move) {
                        $name = $conn->real_escape_string($name);
                        $city = $conn->real_escape_string($city);

                        $sql = "INSERT INTO `students`(`name`, `city`, `email`, `gender`, `phone`,  `subject`, `skill`, `img` ) VALUES ('$name','$city', '$email', '$gender', '$phone','$subject', '$skillsStr','$picNameNew'   )";
                        $result = $conn->query($sql);
                        if ($result) {
                            echo "Student Added Successfully";
                            echo "<script>setTimeout(()=> location.href='./', 2000)</script>";
                        } else {
                            echo "Student Not Added";
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
}
?>
 <div class="container form-control">
    <h2>Students Addmission Form</h2>
 </div>
<div class="container form-control">
<form action="" method="post" enctype="multipart/form-data" >
    

        <input type="text" placeholder="Student Name" name="name" class=" form-control mt-3">
        <br>
        <input type="text" placeholder="Student City" name="city" class=" form-control">
        <br>
        <input type="email" placeholder="email" name="email" class=" form-control">
        <br>
        <input type="number" placeholder="phone" name="phone" class=" form-control">
        
        <br>
     
        Gender:
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="inlineCheckbox1" value="Male" name="gender">
            <label class="form-check-label" for="inlineCheckbox1">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="inlineCheckbox2" value="Female" name="gender">
            <label class="form-check-label" for="inlineCheckbox2">Female</label>
        </div>



       
        <br><br>
        Subject:
        <select class="form-select mt-2" aria-label="Default select example" name="subject" required>
            <option selected>Open this select menu</option>
            <option value="PHP">PHP</option>
            <option value="Python">Python</option>
            <option value="Java">Java</option>
        </select>
        
        
        <br>
        Skills :
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="skills[]" value="PHP">
            <label class="form-check-label" for="inlineCheckbox1">PHP</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="skills[]" value="Python">
            <label class="form-check-label" for="inlineCheckbox2">Python</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="skills[]" value="Java">
            <label class="form-check-label" for="inlineCheckbox2">Java</label>
        </div>


        <br><br>
       


        <div class="input-group mb-3">
            <input type="file" class="form-control" id="getPic" name="pic">
            <label class="input-group-text" for="getPic">Upload</label>
        </div>
    
    
        <br>
        <button type="submit" class="btn btn-primary" name="ast">Submit</button>
    </form>
</div>





<img src="" alt="" style="max-width: 300px;" id="showImg">

<script>
    document.getElementById("getPic").addEventListener("change", function() {
        var reader = new FileReader();
        reader.onload = function() {
            if (reader.readyState == 2) {
                document.getElementById("showImg").src = reader.result;
            }
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>

<br><br><br><br>
<?php
require_once("./footer.php");
?>