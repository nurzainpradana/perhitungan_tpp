<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php
    $page_titles    = "Perhitungan TPP";

    if (isset($page_title)) {
      $page_titles    = $page_title . " | Perhitungan TPP";
    }

    echo $page_titles;
    ?>
  </title>

  <link rel="icon" href="<?= base_url() ?>/assets/dist/img/bekasi.png" type="image/gif">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/dist/css/adminlte.min.css">
  <!-- Loading Animation -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/dist/css/loading.css">


  <!-- Autocomplete Bootstrap Issue on CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/dist/css/customize/autocomplete_issue.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/plugins/daterangepicker/daterangepicker.css">


  <!-- CUSTOM -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/dist/css/custom.css">



  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="<?= base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>


  <!-- DataTables  & Plugins -->
  <script src="<?= base_url(); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/assets/dist/js/adminlte.min.js"></script>
  <!-- JQuery UI -->
  <script src="<?= base_url(); ?>/assets/dist/js/jquery-ui.js"></script>
  <!-- JQuery Ballon -->
  <script src="<?= base_url(); ?>/assets/dist/js/jquery-ballon/jquery-ballon.js"></script>

  <script src="<?= base_url(); ?>/assets/js/sweetalert2.js"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/dist/css/sweetalert.css" />



  <!-- Select2 -->
  <script src="<?= base_url(); ?>/assets/plugins/select2/js/select2.full.min.js"></script>
  <!-- jquery-validation -->
  <script src="<?= base_url(); ?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?= base_url(); ?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>


  <!-- bs-custom-file-input -->
  <script src="<?= base_url(); ?>/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


  <!-- date-range-picker -->
  <script src="<?= base_url(); ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>


  <!-- MY UTILS -->
  <script src="<?= base_url(); ?>/assets/dist/js/my_utils.js"></script>


</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">