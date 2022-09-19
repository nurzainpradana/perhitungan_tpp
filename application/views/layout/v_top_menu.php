<style>
  .bg-navbar-img {
    background-image: url("http://10.246.142.20:54//assets/img/bg-nav-haeder.jpg");
    background-position: left;
    background-repeat: repeat;
    position: relative;
    /* background-repeat: no-repeat;
      width: 100%;
      background-size: cover; */
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-user-check"></i> &nbsp; <?= $this->session->userdata('nama'); ?>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" href="<?php echo base_url() . 'index.php/Login/logout'; ?>">
        <i class="fas fa-sign-out-alt"></i> &nbsp; Sign Out
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->