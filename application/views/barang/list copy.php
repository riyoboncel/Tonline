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

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) class row 
        <div class="col-12 table-responsive">
          <table id="table" class="table table-bordered  table-striped table-sm" cellspacing="0" style="width: 100%;">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Kode</th>
                <th style="width: 50%;">Nama</th>
                <th style="width: 30%;">HrgJl11</th>
                
              </tr>
            </thead>
            <tbody>
            </tbody>

          </table>
        </div>
        -->
        <!-- row main row -->

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 500px;">
          <table id="tables" class="table table-head-fixed text-nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>.</th>
              </tr>
            </thead>
            <tbody>
            </tbody>

          </table>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- modal search keyword -->
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
            <table class="table table-bordered">
              <tr>
                <th>Departemen : <?php echo $key->NmDept ?></th>
              </tr>
              <tr>
                <th>Kode : <?php echo $key->KdBrg ?></th>
                <th>Barcode : <?php echo $key->Barcode ?></th>
              </tr>
              <tr>
                <th>Nama : <?php echo $key->NmBrg ?></th>
              </tr>
            </table>
            <table class="table table-bordered  table-striped table-xl">
              <thead>
                <th>SATUAN</th>
                <th></th>
                <th>H1</th>
                <th>H2</th>
                <th>H3</th>
                <th>H4</th>
              </thead>
              <tbody>
                <!-- satuan 1 -->
                <tr>
                  <td><?php echo $key->Sat_1 ?></td>
                  <td></td>
                  <td><?php echo $key->HrgJl11 ?></td>
                  <td><?php echo $key->HrgJl12 ?></td>
                  <td><?php echo $key->HrgJl13 ?></td>
                  <td><?php echo $key->HrgJl14 ?></td>
                </tr>
                <!-- satuan 2 -->
                <tr>
                  <td><?php echo $key->Sat_2 ?></td>
                  <td><?php echo $key->Isi_2 ?></td>
                  <td><?php echo $key->HrgJl21 ?></td>
                  <td><?php echo $key->HrgJl22 ?></td>
                  <td><?php echo $key->HrgJl23 ?></td>
                  <td><?php echo $key->HrgJl24 ?></td>
                </tr>
                <!-- satuan 3 -->
                <tr>
                  <td><?php echo $key->Sat_3 ?></td>
                  <td><?php echo $key->Isi_3 ?></td>
                  <td><?php echo $key->HrgJl31 ?></td>
                  <td><?php echo $key->HrgJl32 ?></td>
                  <td><?php echo $key->HrgJl33 ?></td>
                  <td><?php echo $key->HrgJl34 ?></td>
                </tr>
                <!-- satuan 4 -->
                <tr>
                  <td><?php echo $key->Sat_4 ?></td>
                  <td><?php echo $key->Isi_4 ?></td>
                  <td><?php echo $key->HrgJl41 ?></td>
                  <td><?php echo $key->HrgJl42 ?></td>
                  <td><?php echo $key->HrgJl43 ?></td>
                  <td><?php echo $key->HrgJl44 ?></td>
                </tr>

              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>


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


  <script type="text/javascript">
    var table;
    $(document).ready(function() {

      //datatables
      table = $('#tables').DataTable({
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

    });
  </script>