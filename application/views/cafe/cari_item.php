  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

          <div class="col-12">
            <div class="info-box mb-2">
              <div class="info-box-content input-group-sm">
                <label for="">Kategori</label>
                <form action="" method="post">
                  <select name="departemen" class="form-control" size="1" onchange="this.form.submit();">
                    <option>Pilih Kategori</option>
                    <?php foreach ($kategori->result() as $key) : ?>
                      <option value="<?php echo $key->KdDept ?>"> <?php echo $key->NmDept ?></option>
                    <?php endforeach ?>
                  </select>
                </form>
              </div>
            </div>
          </div>

          <?php foreach ($item->result() as $key) : ?>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <form action="<?php echo base_url('cafe/cekbarang/') ?>" method="post">
                  <div class="inner text-center">
                    <h3><img src="<?php echo base_url(); ?>assets/img/<?php echo $key->NamaGambar ?>" class="img-fluid mb-2" alt="<?php echo number_format($key->HrgJl11)  ?>"></h3>
                    <!--<h3><img src="<?php echo base_url(); ?>assets/img/<?php echo $key->NamaGambar ?>" class="img-fluid mb-2" alt="<?php echo substr($key->NmBrg, 0, 8)  ?>"></h3>-->
                    <p ><?php echo $key->NmBrg ?></p>
                  
                    <input type="hidden" name="kdbrg" value="<?php echo $key->KdBrg ?>">
                    <input name="nofak" type="hidden" value="<?php echo $faktur->NoPesanJual ?>" />
                    <input type="submit" name="submit" value="Pesan" class="button">
                  </div>
                </form>
              </div>

            </div>
          <?php endforeach ?>
          <!-- ./col -->

        </div>
      </div>
    </div>
    <!-- /.content-header -->

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
