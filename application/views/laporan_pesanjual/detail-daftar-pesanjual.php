  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Laporan Detail PesanJual</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) class row -->
        <div class="row">

          <div class="col-12 ">
            <!-- Main content -->
            <div class="invoice p-3 mb-2">

              <div class="row">
                NoPesan: <?php echo $faktur->NoPesanJual ?>&nbsp; | &nbsp;Cust: <?php echo $faktur->NmCust ?>
              </div>

            </div>

            <div class="invoice p-3 mb-2">
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr align="center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($detailpesanjual->result() as $key) :
                        $total = ($key->Harga - $key->Disc) * $key->Jumlah;
                        $subtotal += (($key->Harga - $key->Disc) * $key->Jumlah);
                      ?>
                        <tr>
                          <td><?php echo $no++ ?></td>
                          <td><?php echo $key->NamaBrg ?></td>
                          <td align="right"><?php echo number_format($key->Harga, 0, ',', '.') ?></td>
                          <td align="center"><?php echo $key->Sat ?></td>
                          <td align="center"><?php echo $key->Jumlah ?></td>
                          <td align="right"><?php echo number_format($total, 0, ',', '.') ?></td>

                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
                <div class="row">

                  <div class="col-12">
                    <hr>
                    <table class="table table-striped table-sm">
                      <tr>
                        <th>Item</th>
                        <td>:&nbsp;<?php echo ($no++) - 1 ?></td>
                      </tr>
                      <tr>
                        <th>Subtotal</th>
                        <td>:&nbsp;<strong>Rp. <?php echo number_format($subtotal, 0, ',', '.') ?></strong></td>
                      </tr>
                    </table>

                  </div>
                  <!-- /.col -->
                </div>

              </div>



            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- daterangepicker -->
  <script src="<?php echo base_url() ?>/assets/plugins/moment/moment.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url() ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>/assets/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url() ?>/assets/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>