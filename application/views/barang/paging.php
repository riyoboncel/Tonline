<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Data Barang Pagination</h1>
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
      <div class="row">
        <div class="col-md-5">
          <form action="<?= base_url('barang/paging') ?>" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" onclick="this.select()" placeholder="cari barang" name="keyword" autocomplete="off" autofocus>
              <div class="input-group-append">
                <!--<input type="submit" class="btn btn-primary" name="submit">-->
                <button class="btn btn-secondary" type="submit">Cari</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5>result : <?= $total_rows ?></h5>
          <table id="example1" class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>NamaBarang</th>
                <th>Stock</th>
                <th>H1</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($barang)) : ?>
                <tr>
                  <td colspan="6">
                    <div class="alert alert-danger">Data tidak di temukan</div>
                  </td>
                </tr>
              <?php endif; ?>
              <?php foreach ($barang as $key) : ?>
                <tr>
                  <th><?= ++$start; ?></th>
                  <td><?= $key['KdBrg'] ?></td>
                  <td><?= $key['NmBrg'] ?></td>
                  <td><?= $key['Stock_Akhir'] ?></td>
                  <td><?= $key['HrgJl11'] ?></td>
                  <td>
                    <a href="" class="badge badge-warning">detail</a>
                  </td>

                </tr>
              <?php endforeach; ?>
            </tbody>

          </table>
          <?= $this->pagination->create_links(); ?>
        </div>
      </div>

    </div>
  </section>

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