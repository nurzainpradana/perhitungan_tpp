<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-1">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img width='10' src="<?= base_url(); ?>/assets/dist/img/ykk3.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">Acc Storage</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class='nav-item'>
        <a href="<?= base_url('index.php');?>" class="nav-link <?= $this->router->fetch_class() == 'Dashboard' ? 'active' : ''; ?>">
        <p>Dashboard</p></a>
      </li>
      <li class='nav-item'>
        <a href="<?= base_url('index.php/Pegawai');?>" class="nav-link <?= $this->router->fetch_class() == 'Pegawai' ? 'active' : ''; ?>">
        <p>Pegawai</p></a>
      </li>
      <li class='nav-item'>
        <a href="<?= base_url('index.php/Jabatan');?>" class="nav-link <?= $this->router->fetch_class() == 'Jabatan' ? 'active' : ''; ?>">
        <p>Jabatan</p></a>
      </li>
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php
        // $this->menulibrary->loadSideBarMenu($this->session->userdata("user_id"));
        ?>



      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>