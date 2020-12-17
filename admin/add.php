<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

if($_POST){
  $file= 'images/'.($_FILES['image']['name']);
  $imgType=pathinfo($file,PATHINFO_EXTENSION);

//   print_r($file);
//   print_r($imgType);

  if($imgType == 'png' && $imgType == 'jpg' && $imgType == 'jpeg'){
        echo "<script>alert('image should be PNG JPG and JPEG')</script>";
  }
  else{
    $title=$_POST['title'];
    $content=$_POST['content'];
    $image=$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],$file);

    $stmt=$pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
    $result=$stmt->execute(
        array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
    );

    if($result){
        echo "<script>alert('Successfully Add!');window.location.href='index.php';</script>";
        
    }
  } 
}
?>

<?php include 'header.html' ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-3">
    <!-- Content Header (Page header) -->   
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">CREATE Blog</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <form action="add.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control"></textarea>
                        </div>
                        <!-- <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="image">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="img">Image</label>
                            <input type="file" name="image" value="">
                        </div>

                        <div class="form-group float-right">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <a href="index.php" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.html' ?>