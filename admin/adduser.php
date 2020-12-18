<?php
session_start();
require '../config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

if($_POST){

    $name=$_POST['name'];
    $mail=$_POST['mail'];

    if($_POST['admin'] == 'on'){
        $role=1;
    }
    else{
        $role=0;
    }

    $stmt= $pdo->prepare("SELECT * FROM users WHERE email=:mail");

    $stmt->bindValue(':mail',$mail);
    $stmt->execute();

    $user= $stmt->fetch(PDO::FETCH_ASSOC);

    if($user)
    {
        echo "<script>alert('mail have been register!')</script>";
        }
        else
        {
    

    $stmt=$pdo->prepare("INSERT INTO users(name,email,role) VALUES (:name,:mail,:role)");
    $result=$stmt->execute(
        array(':name'=>$name,':mail'=>$mail,':role'=>$role)
    );

    if($result){
        echo "<script>alert('Successfully Add!');window.location.href='userlist.php';</script>";   
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
                <h3 class="card-title">CREATE User account</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <form action="adduser.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" name="name" id="name" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">Mail</label>
                            <input type="email" name="mail" id="mail" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Admin</label>
                            <input type="checkbox" name="admin" class="form-control">
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