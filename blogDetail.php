<?php 
session_start();
require 'config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
}

$stmt=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();

$result=$stmt->fetchAll();

$stmtComment=$pdo->prepare("SELECT * FROM comment WHERE post_id=".$_GET['id']);
$stmtComment->execute();

$resultComment=$stmtComment->fetchAll();

if($_POST){

  $comment=$_POST['comment'];
  $stmt=$pdo->prepare("INSERT INTO comment(content,author_id,post_id) VALUES (:content,:autor_id,:post_id)");
  $result=$stmt->execute(
    array(':content'=>$comment,':autor_id'=>$_SESSION['user_id'],':post_id'=>$_GET['id'])
  );

  if($result){
    header('location: blogDetail.php?id='.$_GET['id']);
  }

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper ml-0">

    <!-- Main content -->
    <section class="content">
    <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <h3 class="text-center"><?php echo $result[0]['title']; ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']; ?>" alt="Photo">
  <hr><br>
                <p><?php echo $result[0]['content']; ?></p>
              </div>
              <!-- /.card-body -->
              <h1 class="text-center">Comments</h1><a href="index.php">Go Back To Home Page!</a>

              <div class="card-footer card-comments">
                <div class="card-comment">
                  <!-- User image -->
                  <?php 
                    if($resultComment){
                      $auId=$resultComment[0]['author_id'];
                      $stmtAu=$pdo->prepare("SELECT * FROM users WHERE id=".$auId);
                      $stmtAu->execute();
                    
                      $resultAu=$stmtAu->fetchAll();

                      foreach($resultComment as $resultComment){
                  ?>
                  <div class="comment-text ml-0">
                    <span class="username">
                      <?php echo $resultAu[0]['name']; ?>
                      <span class="text-muted float-right"><?php echo $resultComment['created_at']; ?></span>
                    </span><!-- /.username -->
                    <?php 
                    echo $resultComment['content'];
                    echo "<hr>";
                    }
                  }
                    else{
                      ?>
                        <span>Write Down the First Comment!</span>;
                      <?php
                    }
                    ?>
                  </div>
                  <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
              </div>
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment" name="comment">
                  </div>
                </form>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer ml-0">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>