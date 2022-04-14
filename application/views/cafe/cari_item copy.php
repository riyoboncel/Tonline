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
                  <!--<select name="departemen" class="form-control" size="1" onchange="this.form.submit();">-->
                  <select name="departemen" class="form-control" size="1" onchange="this.form.submit();">
                    <option>Pilih Kategori</option>
                    <?php foreach ($kategori->result() as $key) : ?>
                      <option value="<?php echo $key->KdDept ?>"> <?php echo $key->NmDept ?></option>
                    <?php endforeach ?>
                  </select>
                  <!--<button type="submit" name="filter" class="btn btn-primary ">Filter</button>-->
                </form>

              </div>

            </div>
          </div>

          <?php foreach ($item->result() as $key) : ?>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <form action="<?php echo base_url('cafe/cekbarang/') ?>" method="post">
                  <div class="inner">
                    <h3><img src="<?php echo base_url(); ?>assets/img/<?php echo $key->NamaGambar ?>" class="img-fluid mb-2" alt="<?php echo substr($key->NmBrg, 0, 8)  ?>"></h3>
                    <p><?php echo $key->NmBrg ?></p>
                  </div>
                  <input type="hidden" name="kdbrg" value="<?php echo $key->KdBrg ?>">
                  <input name="nofak" type="hidden" value="<?php echo $faktur->NoPesanJual ?>" />
                  <input type="submit" name="submit" value="Pesan" class="button">

              </div>

              <span></span>
              </form>
            </div>
          <?php endforeach ?>
          <!-- ./col -->

        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <?php foreach ($item->result() as $key) : ?>
            <div class="col-12 col-sm-6 col-md-3">
              <!--<div class="info-box bg-warning" style="background-image: url(<?php echo base_url(); ?>assets/img/<?php echo $key->NamaGambar ?>);">-->
              <div class="info-box bg-warning">
                <div class="info-box-content">
                  <form action="<?php echo base_url('cafe/kirim-barang/') ?>" method="post">
                    <img src="<?php echo base_url(); ?>assets/img/<?php echo $key->NamaGambar ?>" class="img-fluid mb-2" alt="<?php echo substr($key->NmBrg, 0, 8)  ?>">
                    <!--<img src="<?php echo base_url(); ?>assets/img/produk.jpg" height="50" width="80" alt="image">-->
                    <span class="info-box-text"><?php echo $key->NmBrg ?></span>
                    <input type="hidden" name="kdbrg" value="<?php echo $key->KdBrg ?>">
                    <input name="nofak" type="hidden" value="<?php echo $faktur->NoPesanJual ?>" />
                    <input type="submit" name="submit" value="Pesan" class="button">
                    <span></span>
                  </form>
                </div>
              </div>

              <!-- /.info-box -->
            </div>
          <?php endforeach ?>
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