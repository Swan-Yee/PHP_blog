<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

if($_POST){
  
  $name=$_POST['name'];
  $mail=$_POST['mail'];

      $stmt=$pdo->prepare("UPDATE users SET name='$name',email='$mail' WHERE id=".$_GET['id']);
      $result=$stmt->execute();

      if ($result){
        echo "<script>alert('Successfully Update!');window.location.href='userlist.php';</script>";
      }
  }

$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
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
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $result[0]['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">Email</label>
                            <textarea name="mail" id="mail" class="form-control"><?php echo $result[0]['email']; ?></textarea>
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