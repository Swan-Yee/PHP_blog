<?php 
session_start();
require 'config/config.php';

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
  <div class="content-wrapper" style="margin-left:0 !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2" style="text-align:center;display:block;">
            <h1>Blog Site</h1>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <?php

          if(isset($_GET['pageno'])){
              $pageno= $_GET['pageno'];
          }
          else{
          $pageno=1;
          }

          $numOfRec=3;
          $offSet=($pageno -1 )* $numOfRec;
          
            $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
            $stmt->execute();
            $result= $stmt->fetchAll();
  
            $total_page= ceil(count($result)/$numOfRec);

            if($result){
              $i=1;
              foreach($result as $value){
          ?>
          <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                    <h3 class="text-center"><?php echo $value['title']; ?></h3>
              </div>
                <!-- /.user-block -->
              
              <!-- /.card-header -->
              <div class="card-body">
                <a href="blogDetail.php?id=<?php echo $value['id']; ?>">
                  <img class="img-fluid pad" src="admin/images/<?php echo $value['image']; ?>" alt="Photo" width="500" heigth="500">
                </a>
                <p><?php echo substr($value['content'],0, 50); ?><a href="blogDetail.php?id=<?php echo $value['id']; ?>">See More....</a></p>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
              <?php
            $i++;
              }
            }
          ?>
          <!-- /.col -->
      </div>
    </section>
    <!-- /.content -->
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->
            <div class="mt-3 mr-3 d-flex justify-content-end">
            <nav aria-label="Page navigation">
                  <ul class="pagination">
                    <li class="page-item">
                      <a href="?pageno=1" class="page-link">First</a>
                    </li>
                    <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
                      <a href="<?php if($pageno <=1){echo '#';}else{echo '?pageno='.($pageno-1);} ?>" class="page-link">Previous</a>
                    </li>
                    <li class="page-item active">
                      <a href="" class="page-link"><?php echo $pageno ?></a>
                    </li>
                    <li class="page-item <?php if($pageno >= $total_page){echo 'disabled';} ?>">
                      <a href="<?php if($pageno >= $total_page){echo '#';}else{echo '?pageno='.($pageno+1);} ?>" class="page-link">Next</a>
                    </li>
                    <li class="page-item">
                      <a href="?pageno=<?php echo $total_page?>" class="page-link">Last</a>
                    </li>
                  </ul>
              </nav>
            </div>

  <footer class="main-footer" style="margin-left: 0 !important">
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