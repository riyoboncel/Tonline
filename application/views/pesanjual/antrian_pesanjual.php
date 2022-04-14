  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Antrian Pesan Jual</h1>
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


        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><a href="<?php echo base_url('pesanjual/nomor-faktur-new/') ?>"><button type="button" class="btn btn-block bg-gradient-primary"><i class="fas fa-cart-plus fa-lg mr-2"></i>Antrian Baru</button></a></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NoPesanJual</th>
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
                    <td align="center"><a href="<?php echo base_url('pesanjual/entry-pesanjual/') . $key->NoPesanJual ?>">Lanjut</a> |
                      <a onclick="return confirm('Yakin hapus faktur ini?')" href="<?php echo base_url('pesanjual/hapus-faktur/') . $key->NoPesanJual ?>">Hapus</a>
                    </td>

                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url() ?>/assets/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

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
        "responsive": true,
        "autoWidth": false,
      });

    });
  </script>