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

<!-- blom tau -->
<script src="<?php echo base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/toastr.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>

<script>
  $(function() {
    $("#example1").DataTable({
      "aLengthMenu": [
        [25, 50, 75, -1],
        [25, 50, 75, "All"]
      ],
      "pageLength": 50,
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
        }
      },
      "responsive": false,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "aLengthMenu": [
        [25, 50, 75, -1],
        [25, 50, 75, "All"]
      ],
      "pageLength": 50,
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>

<script type="text/javascript">
  var table;
  $(document).ready(function() {

    //datatables
    table = $('#table').DataTable({
      "aLengthMenu": [
        [25, 50, 75, -1],
        [25, 50, 75, "All"]
      ],
      "pageLength": 50,
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
        }
      },
      "responsive": false,
      "processing": true,
      "serverSide": true,
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('barang/get-data-barang/') ?>",
        "type": "POST"
      },


      "columnDefs": [{
        "targets": [0],
        "orderable": false,
      }, ],

    });

    /*
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api(),
          data;

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
            i : 0;
        };

        // Total over all pages
        total = api
          .column(4)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(4, {
            page: 'current'
          })
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(4).footer()).html(
          '$' + pageTotal + ' ( $' + total + ' total)'
        );

      ],


      });
      */

  });
</script>

<footer class="main-footer">
  <strong> &copy; <?= date('Y'); ?> &nbsp; Design &nbsp; By &nbsp;<a href="http://estoh.id" target="_blank">Estoh Software </a></strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>

</html>