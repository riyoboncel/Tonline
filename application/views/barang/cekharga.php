<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12 ">
          <!-- Main content -->
          <div class="invoice p-3 mb-2 rounded">
            <!-- title row -->
            <div class="row">
              <span class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cek HargaJual (<?php echo date_indo($tgl) ?>) <span id="waktu"></span></span>

            </div>

            <div class="col-12">
              <div class="input-group">
                <input type="hidden" name="nofak" id="nofak" value="">
                <input type="text" class="form-control rounded" id="KdBrg" name="KdBrg" required placeholder="ketik kode, barcode atau nama brg">
                <input type="hidden" readonly class="form-control" id="nm_barang" name="nm_barang">
                <div class="input-group-prepend">
                  <div class="input-group-text rounded" id="btnGroupAddon2"><i class="fas fa-search"></i></div>
                </div>
              </div>
            </div>

          </div>

          <div class="invoice p-3 mb-2 rounded">

            <?php if ((!$barangx->result())) : ?>
              <div class="row">
                <div class="col-12">

                  <div class="form-group">
                    <label for="">Kode</label>
                    <span>:&nbsp;</span><br>
                    <label for="">Nama</label>
                    <span>:&nbsp;</span>
                  </div>
                </div>

                <table class="table  table-sm">
                  <thead>
                    <tr>
                      <th>Sat</th>
                      <th>Isi</th>
                      <th>Harga1</th>
                      <th>Harga2</th>
                      <th>Harga3</th>
                      <th>Harga4</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td></td>
                      <td></td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>

                    <tr>
                      <td></td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>

                    <tr>
                      <td></td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>

                    <tr>
                      <td></td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                      <td>0</td>
                    </tr>

                  </tbody>
                </table>
                <!-- /.col -->
              </div>
            <?php endif ?>
            <?php foreach ($barangx->result() as $barang) : ?>
              <div class="row">
                <div class="col-12">

                  <div class="form-group">
                    <label for="">Kode</label>
                    <span>:&nbsp;<?php echo $barang->KdBrg ?></span><br>
                    <label for="">Nama</label>
                    <span>:&nbsp;<?php echo $barang->NmBrg ?></span>
                  </div>
                </div>

                <table class="table  table-sm">
                  <thead>
                    <tr>
                      <th>Sat</th>
                      <th>Isi</th>
                      <th>Harga1</th>
                      <th>Harga2</th>
                      <th>Harga3</th>
                      <th>Harga4</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td><?php echo $barang->Sat_1 ?></td>
                      <td></td>
                      <td><?php echo $barang->HrgJl11 ?></td>
                      <td><?php echo $barang->HrgJl12 ?></td>
                      <td><?php echo $barang->HrgJl13 ?></td>
                      <td><?php echo $barang->HrgJl14 ?></td>
                    </tr>

                    <tr>
                      <td><?php echo $barang->Sat_2 ?></td>
                      <td><?php echo $barang->Isi_2 ?></td>
                      <td><?php echo $barang->HrgJl21 ?></td>
                      <td><?php echo $barang->HrgJl22 ?></td>
                      <td><?php echo $barang->HrgJl23 ?></td>
                      <td><?php echo $barang->HrgJl24 ?></td>
                    </tr>

                    <tr>
                      <td><?php echo $barang->Sat_3 ?></td>
                      <td><?php echo $barang->Isi_3 ?></td>
                      <td><?php echo $barang->HrgJl31 ?></td>
                      <td><?php echo $barang->HrgJl32 ?></td>
                      <td><?php echo $barang->HrgJl33 ?></td>
                      <td><?php echo $barang->HrgJl34 ?></td>
                    </tr>

                    <tr>
                      <td><?php echo $barang->Sat_4 ?></td>
                      <td><?php echo $barang->Isi_4 ?></td>
                      <td><?php echo $barang->HrgJl41 ?></td>
                      <td><?php echo $barang->HrgJl42 ?></td>
                      <td><?php echo $barang->HrgJl43 ?></td>
                      <td><?php echo $barang->HrgJl44 ?></td>
                    </tr>

                  </tbody>
                </table>
                <!-- /.col -->
              </div>
            <?php
            endforeach ?>
          </div>

          <div class="invoice p-3 mb-2 rounded">
            <div class="row">
              <h2><span>Stock Global</span><span>: <?php echo ($global->StockGlobal) ?></span></h2>
            </div>
          </div>
        </div>

      </div><!-- /.col -->
    </div><!-- /.row -->


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


    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/custom.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/toastr.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/jquery.price_format.min.js"></script>
    <script>
      $('form').attr('autocomplete', 'off');
      $('input').attr('autocomplete', 'off');
      $("ul.nav li.dropdown").hover(function() {
        $(this).find(".dropdown-menu").stop(!0, !0).delay(100).fadeIn(500)
      }, function() {
        $(this).find(".dropdown-menu").stop(!0, !0).delay(100).fadeOut(500)
      });
      var pesan = "<?php echo $this->session->flashdata('msg'); ?>",
        error = "<?php echo $this->session->flashdata('error'); ?>";
      pesan ? (toastr.options = {
        positionClass: "toast-top-right"
      }, toastr.success(pesan)) : error && swal(error, "", "error");

      function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('waktu').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
      }

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i
        };
        return i;
      }




      $(document).ready(function() {
        startTime();
        $('#KdBrg').focus();
        $('#KdBrg').autocomplete({
          source: "<?php echo base_url('barang/get_autocomplete/?'); ?>",
          select: function(event, ui) {
            $('[name="KdBrg"]').val(ui.item.kode);
            $('[name="nm_barang"]').val(ui.item.label);
            $('#KdBrg').focus();
          }
        });
      });

      // cari kode barang
      $("#KdBrg").keypress(function(e) {
        var kd_barang = $('#KdBrg').val();
        var nofak = $('#nofak').val();
        if (e.which == 13) {
          if (kd_barang) {
            window.top.location.href = "<?php echo base_url('barang/cekharga/') ?>" + kd_barang;
          }
          return false;
        }
      });



      function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
          (charCode < 45 || charCode > 57)) {
          return false;
        }
        return true;
      }
    </script>