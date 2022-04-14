<link href="<?php echo base_url() ?>/assets/css/jquery.dataTables.min.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Data Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Barang</a></li>
            <li class="breadcrumb-item active">Detail</li>
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
      <div class="col-12 table-responsive">
        <table id="tbBarang" class="table table-bordered  table-striped table-sm">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Brg</th>
              <th>Stock</th>
              <th align="center">Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>

        </table>
      </div>
      <!-- /.row  -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- modal search keyword 
<?php foreach ($barang->result() as $key) : ?>
  <div class="modal fade" id="modalKeyword<?php echo $key->KdBrg ?>" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newSubMenuModalLabel">Detail Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="col-12 table-responsive">
          <table id="tbBarang" class="table table-bordered  table-striped table-sm">
            <thead>
              <tr>
                <th>Departemen</th>
                <th>kode</th>
                <th>Nama</th>
                <th>Barcode</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $key->NmDept ?></td>
                <td><?php echo $key->KdBrg ?></td>
                <td><?php echo $key->NmBrg ?></td>
                <td><?php echo $key->Barcode ?></td>
                <td><?php echo $key->HrgJl11 ?></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
-->

<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
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
<!-- DataTables -->
<script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!--
<script src="<?php echo base_url() ?>/assets/js/jquery-1.10.2.js"></script>
-->
<script src="<?php echo base_url() ?>/assets/js/dataTables/jquery.dataTables.js"></script>

<script>
  $('#tbBarang').DataTable({

    "aLengthMenu": [
      [10, 25, 50, 75, -1],
      [10, 25, 50, 75, "All"]
    ],
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
      "url": '<?php echo base_url(); ?>barang/json_produk',
      "type": "POST",
    },
    "columns": [{
        "data": "KdBrg"
      },
      {
        "data": "NmBrg"
      },

      {
        "data": "Stock_Akhir"
      },
      {
        "data": "Aksi"
      },
    ],
  });
</script>