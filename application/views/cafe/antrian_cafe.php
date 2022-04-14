  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Antrian Pesan Cafe</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Pesan</a></li>
              <li class="breadcrumb-item active">Antrian Pesan Cafe</li>
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
            <h3 class="card-title"><a href="<?php echo base_url('cafe/nomor-faktur-new/') ?>"><button type="button" class="btn btn-block bg-gradient-primary"><i class="fas fa-cart-plus fa-lg mr-2"></i>Pesan Baru</button></a></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-12 table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NoPesan</th>
                    <th>Tanggal</th>
                    <th>Cust</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pending->result() as $key) : ?>
                    <tr>
                      <td><?php echo $no++ ?></td>
                      <td><?php echo $key->NoPesanJual ?></td>
                      <td><?php echo date_indo($key->Tanggal) ?></td>
                      <td><?php echo $key->NmCust ?></td>
                      <td align="center"><a href="<?php echo base_url('cafe/form-cafe/') . $key->NoPesanJual ?>">Lanjut</a> |
                        <a onclick="return confirm('Yakin hapus faktur ini?')" href="<?php echo base_url('cafe/hapus-faktur/') . $key->NoPesanJual ?>">Hapus</a></td>

                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->


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
  <!-- DataTables -->
  <script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <!-- blom tau -->
  <script src="<?php echo base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/js/toastr.min.js"></script>

  <script>
    $(function() {
      $("#example1").DataTable({
        /* untuk scroll datatable 
        "scrollY": 350,
        "scrollX": true, */
        "aLengthMenu": [
          [25, 50, 75, -1],
          [25, 50, 75, "All"]
        ],
        "pageLength": 25,
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

        /* untuk sum footer callback */
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
            .column(2)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(2, {
              page: 'current'
            })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(2).footer()).html(
            'Rp ' + pageTotal
          );

          /* ------- */
          // Total over all pages
          total = api
            .column(3)
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(3, {
              page: 'current'
            })
            .data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(3).footer()).html(
            'Rp ' + pageTotal
            //'Rp ' + pageTotal + ' ( Rp ' + total + ' total)'
          );
        }

      });

    });
  </script>