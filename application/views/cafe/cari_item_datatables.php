<!--<link href="<?php echo base_url() ?>/assets/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-12">
          <div class="info-box mb-2">

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) class row -->

      <div class="col-12 table-responsive">
        <table id="tbBarang" class="table table-bordered  table-striped table-sm">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Brg</th>
              <th align="center">Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>

        </table>
      </div>

      <!-- /.row (main row) -->
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

<script src="<?php echo base_url() ?>/assets/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>/assets/js/dataTables/jquery.dataTables.js"></script>

<script>
  $('#tbBarang').DataTable({
    /*
    "aLengthMenu": [
      [25, 50, 75, -1],
      [25, 50, 75, "All"]
    ], */
    "pageLength": 10,
    "language": {
      "search": "Cari",
      "info": "Menampilkan _START_ Sampai _END_ Dari _TOTAL_ data",
      "lengthMenu": "Menampilkan _MENU_ baris",
      "infoEmpty": "Tidak ditemukan",
      "infoFiltered": "(pencarian dari _MAX_ data)",
      "zeroRecords": "Data tidak ditemukan",
      "paginate": {
        "next": "Selanjutnya",
        "previous": "Sebelumnya",
      },
    },

    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": false,
    "responsive": false,
    "processing": true,
    "serverSide": true,
    "order": [],


    "ajax": {
      "url": '<?php echo base_url(); ?>cafe/json_produk',
      "type": "POST",
    },
    "columns": [{
        "data": "KdBrg"
      },
      {
        "data": "NmBrg"
      },
      {
        "data": "Aksi"
      },
    ],
  });
</script>