<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item "><?php echo $title ?></li>
            <li class="breadcrumb-item "><span><?php echo date_indo($tgl) ?></span> <span id="waktu"></span>&nbsp;|&nbsp;
              <?php echo $faktur->NoKirim ?>&nbsp; | &nbsp;</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label>Lokasi Asal</label>
                  <form action="<?php echo base_url('opnameviakirim/ganti_lokasi_asal/') ?>" method="post">
                    <input type="hidden" class="form-control select2" name="nofak" id="nofak" value="<?php echo $faktur->NoKirim ?>">
                    <select name="asal" class="form-control select2" style="width: 100%;" onchange="this.form.submit();">
                      <option hidden>Lokasi Asal : <?php echo $faktur->LokasiAsal ?></option>
                      <?php foreach ($lokasi->result() as $key) : ?>
                        <option class="form-control" value="<?php echo $key->KdLokasi ?>"> <?php echo $key->KdLokasi ?></option>
                      <?php endforeach ?>
                    </select>
                  </form>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Lokasi Tujuan</label>
                  <form action="<?php echo base_url('opnameviakirim/ganti_lokasi_tujuan/') ?>" method="post">
                    <input type="hidden" class="form-control select2" name="nofak" id="nofak" value="<?php echo $faktur->NoKirim ?>">
                    <select name="tuju" class="form-control select2" style="width: 100%;" onchange="this.form.submit();">
                      <option hidden>Lokasi Tujuan : <?php echo $faktur->LokasiTuju ?></option>
                      <?php foreach ($lokasi->result() as $key) : ?>
                        <option class="form-control" value="<?php echo $key->KdLokasi ?>"> <?php echo $key->KdLokasi ?></option>
                      <?php endforeach ?>
                    </select>
                  </form>
                </div>

              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <div class="input-group input-group-sm">
                  <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoKirim ?>">
                  <input type="text" class="form-control rounded" id="KdBrg" name="KdBrg" required placeholder="ketik kode, barcode atau nama brg">
                  <input type="hidden" readonly class="form-control" id="nm_barang" name="nm_barang">
                  <div class="input-group-prepend">
                    <div class="input-group-text rounded" id="btnGroupAddon2"><a href=""><i class="fas fa-search"></i></a></div>
                  </div>
                </div>

              </div>

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
                        <td><input type="text" class="form-control-sm" disabled value="<?php echo $key->NamaBrg ?>"></td>
                        <td><?php echo $key->Stock ?></td>
                        <td>
                          <a class="form-control-sm btn-warning" href="#modalEditSatuan<?php echo $key->KdBrg ?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> <?php echo $key->Sat ?></a>
                        </td>
                        <td>
                          <form action="<?php echo base_url('opnameviakirim/edit_fisik/') ?>" method="post">
                            <input name="kdbrg" type="hidden" id="kdbrg" value="<?php echo $key->KdBrg ?>" />
                            <input name="nofak" type="hidden" id="nofak" value="<?php echo $key->NoKirim ?>" />
                            <input style="text-align: center;" class="form-control-sm" name="fisik" type="text" id="fisik" size="3" onclick="this.select()" onkeypress="return isNumber(event)" value="<?php echo $key->Fisik ?>" />
                          </form>
                        </td>
                        <td><?php echo $key->Jumlah ?></td>
                        <td><?php echo $key->Sat ?> </a></td>
                        <td><?php echo $key->Isi ?></td>
                        <td><a onclick="return confirm('Yakin hapus data ini?');" href="<?php echo base_url('opnameviakirim/hapus-barang-opname/') . $key->NoKirim . "/" . $key->KdBrg ?>">
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
      source: "<?php echo base_url('opnameviakirim/get_autocomplete/?'); ?>",
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
        window.top.location.href = "<?php echo base_url('opnameviakirim/cekbarang/') ?>" + nofak + "/" + kd_barang;
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

<footer class="main-footer">
  <div class="col-4" style="float: left;">
    <a href="#"><button type="button" class="btn btn-secondary btn-sm float-right" style="margin-right: 1px;">
        <i class="fas fa-folder fa-lg mr-2"></i>
      </button></a>
  </div>
  <div class="col-4" style="float: left;">
    <a href="<?php echo base_url('opnameviakirim/antrian-opname/')  ?>">
      <button type="button" class="btn btn-primary btn-sm float-right" style="margin-right: 5px;">
        <i class="fas fa-cart-plus fa-lg mr-2"></i>
      </button>
    </a>
  </div>
  <div class="col-4" style="float: right;">
    <?php if (empty($list->result())) {
      $disable = 'disabled';
    } else {
      $disable = '';
    } ?>
    <form class="form-inline" action="<?php echo base_url('opnameviakirim/go_simpan/') ?>" method="post">
      <input type="hidden" name="NoKirim" value="<?php echo $faktur->NoKirim ?>">
      <button type="submit" <?php echo $disable; ?> onclick="return confirm('Yakin Simpan Entry Opname ini?');" class="btn btn-success btn-sm float-right" style="margin-right: 5px;">
        <i class="far fa-credit-card"></i> Simpan
      </button>
    </form>
  </div>

</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->