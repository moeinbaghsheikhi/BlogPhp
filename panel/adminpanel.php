<?php
require_once "../config/loader.php";

if(!isset($_SESSION['login'])){
    header('Location: ../index.php');
} else if($_SESSION['role'] != "admin") header('Location: ../index.php');


$query = "SELECT * FROM `users` WHERE role=?";

// stmt
$stmt = $conn->prepare($query);

// bind
$stmt->bindValue(1, "writer");

// exe
$stmt->execute();
$writers = $stmt->fetchAll(PDO::FETCH_OBJ);


// submit form and add a post
if(isset($_POST['submit'])){
    $target_dir = "../uploads/";
    if(empty($_FILES['image']['tmp_name'])) {
        echo "<p class='alert alert-danger'>Please upload cover from post:</p>";
    }else{
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                  $uploadOk = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = basename($_FILES["image"]["name"]);
        $writer_id = $_POST['writer'];

        if($writer_id == ""){
            echo "<p class='alert alert-danger'>Please select a writer:</p>";
            $uploadOk = false;
        }

        if($uploadOk){
            $query = "INSERT INTO `posts` SET title=?, description=?, image=?, writer_id=?";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(1, $title);
            $stmt->bindValue(2, $description);
            $stmt->bindValue(3, $image);
            $stmt->bindValue(4, $writer_id);
            $stmt->execute();

            if($stmt){
                echo "<p class='alert alert-success'>Posted Successfuly</p>";
            }
        }
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Writer Panel</title>

    <style>
        .form-group{
            margin-bottom: 15px;
        }
        label{
            margin-bottom: 5px;
        }
        .alert{
            margin: 20px 100px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 80px;">
        <h2>Write a post:</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">select writer:</label>
                <select name="writer" id="" class="form-control">
                    <option value="">select</option>
                    <?php foreach ($writers as $writer): ?>
                        <option value="<?= $writer->id ?>"><?= $writer->username ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <input type="text" placeholder="title" class="form-control" name="title">
            </div>

            <div class="form-group">
                <label for="image">image:</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Body:</label>
                <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">Add post</button>
            </div>
        </form>
    </div>
</div>
</body>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>