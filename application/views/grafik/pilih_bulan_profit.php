  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Grafik Profit</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Penjualan</a></li>
              <li class="breadcrumb-item active">Grafik Profit</li>
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Grafik Profit Bulanan</h3>
          </div>

          <div class="card-body">
            <form class="form-inline" action="<?php echo base_url('grafik/grafik-profit-bulanan') ?>" method="post">
              <div class="form-group">
                <label for="pwd" style="width: 100px">Bulan : </label>
                <select name="bulan" id="bulan" class="form-control" required>
                  <option value="">Pilih Bulan</option>
                  <option <?php if ($bulan == '01') {
                            echo 'selected';
                          } ?> value="01">Januari</option>
                  <option <?php if ($bulan == '02') {
                            echo 'selected';
                          } ?> value="02">Februari</option>
                  <option <?php if ($bulan == '03') {
                            echo 'selected';
                          } ?> value="03">Maret</option>
                  <option <?php if ($bulan == '04') {
                            echo 'selected';
                          } ?> value="04">April</option>
                  <option <?php if ($bulan == '05') {
                            echo 'selected';
                          } ?> value="05">Mei</option>
                  <option <?php if ($bulan == '06') {
                            echo 'selected';
                          } ?> value="06">Juni</option>
                  <option <?php if ($bulan == '07') {
                            echo 'selected';
                          } ?> value="07">Juli</option>
                  <option <?php if ($bulan == '08') {
                            echo 'selected';
                          } ?> value="08">Agustus</option>
                  <option <?php if ($bulan == '09') {
                            echo 'selected';
                          } ?> value="09">September</option>
                  <option <?php if ($bulan == '10') {
                            echo 'selected';
                          } ?> value="10">Oktober</option>
                  <option <?php if ($bulan == '11') {
                            echo 'selected';
                          } ?> value="11">November</option>
                  <option <?php if ($bulan == '12') {
                            echo 'selected';
                          } ?> value="12">Desember</option>
                </select>
              </div> <br><br>
              <div class="form-group">
                <label for="email" style="width: 100px">Tahun : </label>
                <select name="tahun" id="tahun" class="form-control" required>
                  <option value="">Pilih Tahun</option>
                  <?php foreach ($tahun as $key) : ?>
                    <option <?php if ($year == $key['thn']) {
                              echo 'selected';
                            } ?> value="<?php echo $key['thn'] ?>"><?php echo $key['thn'] ?></option>
                  <?php endforeach ?>
                </select>
              </div><br><br>
              <div style="margin-left: 100px">
                <button type="submit" id="btnSimpanBiaya" class="btn btn-success">LIHAT</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url() ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

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
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script src="<?php echo base_url() . 'assets/js/grafik/jquery.js' ?>"></script>
  <script src="<?php echo base_url() . 'assets/js/grafik/highcharts.js' ?>"></script>