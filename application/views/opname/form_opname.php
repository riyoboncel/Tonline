<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><?php echo $title ?></li>
            <li class="breadcrumb-item "><span><?php echo date_indo($tgl) ?></span> <span id="waktu"></span>&nbsp;|&nbsp;
              <?php echo $faktur->NoOpname ?>&nbsp; | &nbsp;</li>
          </ol>
        </div>
      </div>
      <div class="row">

        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-2 rounded">
            <!-- title row -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <form action="<?php echo base_url('opname/ganti_lokasi/') ?>" method="post">
                    <input type="hidden" class="form-control select2" name="nofak" id="nofak" value="<?php echo $faktur->NoOpname ?>">
                    <select name="asal" class="form-control select2" style="width: 100%;" onchange="this.form.submit();">
                      <option hidden>Lokasi: <?php echo $faktur->KdLokasi ?></option>
                      <?php foreach ($lokasi->result() as $key) :
                      ?>
                        <option class="form-control" value="<?php echo $key->KdLokasi ?>"> <?php echo $key->KdLokasi ?></option>
                      <?php endforeach
                      ?>
                    </select>
                  </form>
                </div>
              </div>

              <div class="col-12">
                <div class="input-group">
                  <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoOpname ?>">
                  <input type="text" class="form-control rounded" id="KdBrg" name="KdBrg" required placeholder="ketik kode, barcode atau nama brg">
                  <input type="hidden" readonly class="form-control" id="nm_barang" name="nm_barang">
                  <div class="input-group-prepend">
                    <div class="input-group-text rounded" id="btnGroupAddon2"><a href=""><i class="fas fa-search"></i></a></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr align="left">
                      <th>No</th>
                      <th>Kode</th>
                      <th>Barang</th>
                      <th>Stock</th>
                      <th>Satuan</th>
                      <th>Fisik</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Isi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($list->result() as $key) : ?>
                      <tr align="left">
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $key->KdBrg ?></td>
                        <td><input type="text" disabled value="<?php echo $key->NamaBrg ?>"></td>
                        <td><?php echo $key->Stock ?></td>
                        <td>
                          <a class="btn-warning" href="#modalEditSatuan<?php echo $key->KdBrg ?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> <?php echo $key->Sat ?></a>
                        </td>
                        <td>
                          <form action="<?php echo base_url('opname/edit_fisik/') ?>" method="post">
                            <input name="kdbrg" type="hidden" id="kdbrg" value="<?php echo $key->KdBrg ?>" />
                            <input name="nofak" type="hidden" id="nofak" value="<?php echo $key->NoOpname ?>" />
                            <input style="text-align: center;" name="fisik" type="text" id="fisik" size="3" onclick="this.select()" onkeypress="return isNumber(event)" value="<?php echo $key->Fisik ?>" />
                          </form>
                        </td>
                        <td><?php echo $key->Jumlah ?></td>
                        <td><?php echo $key->Sat ?> </a></td>
                        <td><?php echo $key->Isi ?></td>
                        <td><a onclick="return confirm('Yakin hapus data ini?');" href="<?php echo base_url('opname/hapus-barang-opname/') . $key->NoOpname . "/" . $key->KdBrg ?>">
                            <p style="color: red"><i class="fa fa-times"></i></p>
                          </a>
                        </td>

                      </tr>

                    <?php
                    endforeach ?>
                  </tbody>
                </table>
              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">

              <div class="col-6">
                <hr>
                <table class="table table-striped table-sm">
                  <tr>
                    <th>Operator</th>
                    <td><?php echo $faktur->NmUser ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-6">
                <a href="<?php echo base_url('opname/antrian-opname/') . $faktur->NoOpname . "/"  ?>"><button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  </button></a>
              </div>
              <div class="col-6">
                <form class="form-inline" action="<?php echo base_url('opname/go_simpan/') ?>" method="post">
                  <input type="hidden" name="noopname" value="<?php echo $faktur->NoOpname ?>">
                  <button type="submit" class="btn btn-success float-right" style="margin-right: 5px;">
                    <i class="far fa-credit-card"></i> Simpan</button>
                </form>
              </div>

            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
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
<!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
<script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/bootstrap.js"></script>
<script src="<?php echo base_url() ?>/assets/js/custom.js"></script>
<script src="<?php echo base_url() ?>/assets/js/sweetalert.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/toastr.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.price_format.min.js"></script>
<script type="text/javascript">
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
      source: "<?php echo base_url('opname/get_autocomplete/?'); ?>",
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
        window.top.location.href = "<?php echo base_url('opname/cekbarang/') ?>" + nofak + "/" + kd_barang;
      }
      return false;
    }
  });

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
</script>