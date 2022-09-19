<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Perhitungan TPP | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">

  <style>
    body,
    html {
      background-image: url("<?= base_url() . 'assets/img/library2.jpg'; ?>");
      background-repeat: no-repeat;
      width: 100%;
      background-size: cover;
    }
  </style>
  <link rel="icon" href="<?= base_url() ?>/assets/dist/img/ykk3.png" type="image/gif">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">

    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <h3 class="text-center text-bold text-navy"><b>Perhitungan TPP</b></h3>
        <hr>
        <?php
        if ($this->session->flashdata('error')) {
        ?>
          <p class="login-box-msg text-danger"><?= $this->session->flashdata('error'); ?></p>
        <?php
        } else {
        ?>
          <p class="login-box-msg text-primary ">Silahkan Login terlebih dahulu</p>
        <?php
        }
        ?>


        <form action="<?= base_url('index.php/Login/CheckLogin'); ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="user_id" class="form-control" placeholder="User ID" autocomplete="off" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <div class="card-footer bg-primary">

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>
</body>

</html>