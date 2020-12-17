<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

if($_POST){
  
  $id=$_POST['id'];
  $title=$_POST['title'];
  $content=$_POST['content'];

  if($_FILES['image']['name']!=null){
  
    $file= 'images/'.($_FILES['image']['name']);
    $imgType=pathinfo($file,PATHINFO_EXTENSION);

    if($imgType == 'png' && $imgType == 'jpg' && $imgType == 'jpeg'){
          echo "<script>alert('image should be PNG JPG and JPEG')</script>";
    }
    else{
      $image=$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);

      $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
      $result=$stmt->execute();

      if ($result){
        echo "<script>alert('Successfully Update include image!');window.location.href='index.php';</script>";
      }
    }
  }
  else
  {
      $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
      $result=$stmt->execute();

      if ($result){
        echo "<script>alert('Successfully Update!');window.location.href='index.php';</script>";
      }
  }
}
$stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();

$result=$stmt->fetchAll();

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
                    <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo $result[0]['title']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control"><?php echo $result[0]['title']; ?></textarea>
                        </div>
                        <!-- <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="image">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="img">Image</label><br>
                            <img src="images/<?php echo $result[0]['image'] ?>" alt="" srcset="" width="300" height="300"><br>
                            <br><input type="file" name="image" value="">
                        </div>

                        <div class="form-group float-right">
                            <input type="submit" value="Update" class="btn btn-primary">
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