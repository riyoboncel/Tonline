<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="Aplikasi Point of Sales" />
  <meta name="author" content="riyoboncel" />
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/') ?>/img/favicon.ico" />
  <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
  <title>Tumbas Online</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/dist/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/dist/css/opensans.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link href="<?php echo base_url() ?>/assets/css/toastr.min.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>/assets/css/jquery-ui.css" rel="stylesheet" /><!-- dropdown search -->

  <link href="<?php echo base_url() ?>/assets/css/font-awesome.css" rel="stylesheet" /> <!-- button aksi lama -->

  <script type="text/javascript">
    function check_session_id() {
      fetch('<?php echo base_url('login/cek_session') ?>').then(function(response) {

        return response.json();

      }).then(function(responseData) {

        if (responseData.output == 'logout') {
          window.location.href = '<?php echo base_url('login/logout/') ?>';
        }

      });
    }

    setInterval(function() {

      check_session_id();

    }, 10000);
  </script>

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed text-xs">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item">
          <h3><?php echo $user->NmUser ?></h3>
        </li>
        <!--<li class="nav-item"><?php echo $seting->Alamat1 ?></li>-->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!--
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('pesanjual/nomor-faktur/') ?>">
            <i class="fas fa-cart-plus"></i>
          </a>
        </li>
        -->
        <li class="nav-item">
          <a class="nav-link" href="">
            <i class="fas fa-refresh"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="return confirm('Yakin Keluar dari Program ini?');" href="<?php echo base_url('login/logout/') ?>">
            <i class=" fas fa-power-off text-info"></i>
          </a>
        </li>

      </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Brand Logo -->
      <a href="<?php echo base_url('dashboard') ?>" class="brand-link">
        <img src="<?php echo base_url() ?>/assets/dist/img/logo.png" alt="Estoh Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $seting->Nama ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- ====================================================== sidebar menu ============================================================================ -->
        <?php if ($user->KasirJual == 0) {
          $disable = 'disabled';
        } else {
          $disable = '';
        } ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Barang</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th-large"></i>
                <p>
                  Barang
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('barang/') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('barang/databarang') ?>" class="nav-link <?php echo $disable; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang2</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('barang/cekharga') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cek Harga Jual</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Pesan Jual</li>
            <li class="nav-item has-treeview ">
              <!-- tambahin menu-open pada class untuk open menu -->
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Pesan Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('pra/nomor-faktur/') ?>" class="nav-link active <?php echo $disable; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Pra Pesan Jual</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('pesanjual/nomor-faktur/') ?>" class="nav-link active <?php echo $disable; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Pesan Jual</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('cafe/nomor-faktur/') ?>" class="nav-link active <?php echo $disable; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Pesan Cafe</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Laporan Pesan Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <!--  laporan pesan jual -->
                <li class="nav-item">
                  <a href="<?php echo base_url('laporan_pesanjual/laporan-daftar-pesanjual/') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Daftar Pesanjual</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <!--<?php echo base_url('laporan_pesanjual/lap-jumlah-pesanjual/') ?>-->
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Jumlah Pesan Penjualan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <!-- <?php echo base_url('laporan_pesanjual/lap-total-pesanjual/') ?> -->
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Total Pesan Penjualan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <!-- <?php echo base_url('laporan_pesanjual/rekap-pesanjual-percustomer/') ?> -->
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Pesan Jual Per Customer</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Penjualan</li>
            <li class="nav-item has-treeview ">
              <!-- tambahin menu-open pada class untuk open menu -->
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Faktur Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('fakturjual/nomor-faktur/') ?>" class="nav-link <?php echo $disable; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Faktur Jual</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Laporan Faktur Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <!--  laporan faktur jual -->
                <li class="nav-item">
                  <a href="<?php echo base_url('laporan_penjualan/laporan-fakturjual/') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Faktur Jual</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('laporan_penjualan/laporan-detailjual/') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Detail Jual</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Laporan Rekap Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('rekap-jual') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Laporan Rekap Jual</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Grafik Jual
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('grafik/stok-barang/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grafik Stock Barang</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('grafik/profit-bulanan/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grafik Profit Bulanan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('grafik/penjualan-bulanan/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grafik Penjualan Bulanan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('grafik/penjualan-tahun/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grafik Penjualan Tahun</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Utility</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Entry Faktur Opname
                  <i class="right fas fa-angle-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="<?php echo base_url('opname/nomor-faktur/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Faktur Opname (Final)</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('opnameviakirim/nomor-faktur/') ?>" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Entry Faktur Opname Via Kirim</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>


          <hr />

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?php echo base_url('dashboard/gantipassword/') ?>" class="nav-link">
                <i class="nav-icon fas fa-key"></i>
                <p>Ganti Password</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a onclick="return confirm('Yakin Keluar dari Program ini?');" href="<?php echo base_url('login/logout/') ?>" class="nav-link">
                <i class="nav-icon fa fa-power-off text-info"></i>
                <p>Keluar</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>

      <!-- /.sidebar -->
    </aside>