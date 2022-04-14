<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12 ">
          <!-- Main content -->
          <div class="invoice p-3 mb-2">
            <!-- title row -->
            <div class="row">
              <?php if ($spv->HargaJualBolehEdit <> 1) {
                $read = 'disabled';
              } else {
                $read = '';
              } ?>
              <div class="col-12">
                <?php echo $title ?>
                &nbsp;|&nbsp;
                <?php echo $faktur->NoPesanJual ?>&nbsp; | &nbsp;Cust:(<?php echo $faktur->KdCust ?>) <?php echo $faktur->NmCust ?>
              </div>
              <div class="col-12">
                <div class="info-box mb-2">
                  <!--<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>-->
                  <div class="info-box-content input-group-sm">
                    <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                    <input type="text" class="form-control" id="KdCust" onclick="this.select()" name="KdCust" value="<?php echo $faktur->KdCust ?>" required placeholder="Ketik Cust Kode / Nama">
                    <input type="text" readonly class="form-control" id="nm_cust" name="nm_cust" value="<?php echo $faktur->NmCust ?>" placeholder="Cari Customer">
                  </div>

                  <div class="info-box-content input-group-sm">
                    <form action="<?php echo base_url('pesanjualdetail/edit_jenis_harga/') ?>" method="post">
                      <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                      <input name="nmuser" type="hidden" id="nmuser" value="<?php echo $spv->NmUser ?>" />
                      <select name="jnshrg" <?php echo $read ?> class="form-control" size="1" onchange="this.form.submit();">
                        <option hidden><?php echo $faktur->JenisHrg ?></option>
                        <option value="H1">H1</option>
                        <option value="H2">H2</option>
                        <option value="H3">H3</option>
                        <option value="H4">H4</option>
                      </select>
                    </form>
                    <button type="button" href="#modalAgree" data-toggle="modal" class="btn btn-block btn-warning btn-sm">Agreement</button>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->

              </div>

              <div class="col-12">
                <div class="input-group">
                  <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                  <input type="text" class="form-control" id="KdBrg" name="KdBrg" required placeholder="ketik kode, barcode atau nama brg">
                  <input type="hidden" readonly class="form-control" id="nm_barang" name="nm_barang">
                  <div class="input-group-prepend">

                    <div class="input-group-text" id="btnGroupAddon2">
                      <a href="<?php echo base_url('pesanjualdetail/cari-barang/') . $faktur->NoPesanJual ?>"><i class="fas fa-search"></i></a>
                    </div>

                  </div>
                </div>
              </div>

            </div>

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr align="center">
                      <th>No</th>
                      <th>Nama</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Harga</th>
                      <th>Disc</th>
                      <th>Isi</th>
                      <!-- <th>Sales</th> -->
                      <th>Total</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($list->result())) : ?>
                      <tr widht='100%'>
                        <td colspan="10">
                          <div role="alert">Pesanan blom ada</div>
                        </td>
                      </tr>
                    <?php endif ?>
                    <?php foreach ($list->result() as $key) :
                      $total = ($key->Harga - $key->Disc) * $key->Jumlah;
                    ?>
                      <tr align="left">
                        <td><?php echo $no++ ?></td>
                        <td>
                          <input class="form-control-sm" name="brg" type="text" size="20" disabled value="<?php echo $key->NamaBrg ?>" />
                        </td>
                        <td>
                          <form action="<?php echo base_url('pesanjualdetail/edit_jumlah_beli/') ?>" method="post">
                            <input name="KdBrg_e" type="hidden" id="KdBrg_e" value="<?php echo $key->KdBrg ?>" />
                            <input name="nofak_e" type="hidden" id="nofak_e" value="<?php echo $key->NoPesanJual ?>" />
                            <input class="form-control-sm" style="text-align: center;" name="jml" type="text" id="jml" size="3" onclick="this.select()" onkeypress="return isNumber(event)" value="<?php echo $key->Jumlah ?>" />
                          </form>
                        </td>
                        <td><a class="form-control-sm btn-warning" href="#modalEditSatuan<?php echo $key->KdBrg ?>" data-toggle="modal" title="Edit"> <?php echo $key->Sat ?></a>
                        </td>
                        <td>
                          <form action="<?php echo base_url('pesanjualdetail/edit_harga_jual/') ?>" method="post">
                            <input name="KdBrg_h" type="hidden" id="KdBrg_h" value="<?php echo $key->KdBrg ?>" />
                            <input name="nmuser" type="hidden" id="nmuser" value="<?php echo $spv->NmUser ?>" />
                            <input name="nofak_h" type="hidden" id="nofak_h" value="<?php echo $key->NoPesanJual ?>" />
                            <input class="form-control-sm" style="text-align: center;" <?php echo $read ?> name="hrg" type="text" id="hrg" size="7" onclick="this.select()" onkeypress="return isNumber(event)" value="<?php echo number_format($key->Harga, 0, ',', '.') ?>" />
                          </form>
                        </td>
                        <td>
                          <form action="<?php echo base_url('pesanjualdetail/edit_diskon_beli/') ?>" method="post">
                            <input name="kdbrg" type="hidden" value="<?php echo $key->KdBrg ?>" />
                            <input name="nmuser" type="hidden" value="<?php echo $spv->NmUser ?>" />
                            <input name="nofak" type="hidden" value="<?php echo $key->NoPesanJual ?>" />
                            <input name="disc" class="form-control-sm" type="text" size="5" <?php echo $read ?> onclick="this.select()" onkeypress="return isDisc(event)" value="<?php echo $key->Disc ?>" />
                          </form>
                        </td>
                        <td><?php echo $key->Isi ?></td>
                        <!-- ===================== Sales Detail =============
                        <td>
                          <form action="<?php echo base_url('pesanjualdetail/edit_kdsales/') ?>" method="post">
                            <input name="kdbrg" type="hidden" id="kdbrg" value="<?php echo $key->KdBrg ?>" />
                            <input name="nofak" type="hidden" id="nofak" value="<?php echo $key->NoPesanJual ?>" />
                            <input class="form-control-sm" style="text-align: center;" name="sales" type="text" id="sales" size="3" onclick="this.select()" value="<?php echo $key->KdSales ?>" />
                          </form>
                        </td>
                        ================== -->
                        <td><input class="form-control-sm" type="text" size="5" disabled value="<?php echo $total ?>" /></td>
                        <td><a onclick="return confirm('Yakin hapus data ini?');" href="<?php echo base_url('pesanjualdetail/hapus-barang-beli/') . $key->NoPesanJual . "/" . $key->KdBrg ?>">
                            <p style="color: red"><i class="fa fa-times"></i></p>
                          </a>
                        </td>
                      </tr>
                      <?php
                      $tot_item += $key->Jumlah;
                      $tot_belanja += (($key->Harga - $key->Disc) * $key->Jumlah);
                      ?>
                    <?php
                    endforeach ?>
                  </tbody>
                </table>
              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">

              <div class="col-12">
                <hr>
                <table class="table table-striped table-sm">
                  <tr>
                    <th>Item</th>
                    <td>:&nbsp;<?php echo ($no++) - 1 ?></td>
                  </tr>
                  <tr>
                    <th>Subtotal</th>
                    <td>:&nbsp;<strong>Rp. <?php echo number_format($tot_belanja, 0, ',', '.') ?></strong></td>
                  </tr>
                  <!--
                  <tr>
                    <th>Sales</th>
                    <td>
                      <div class="info-box-content col-6 input-group-sm">
                        <?php if ($faktur->KdSales == '') {
                          $value = 'Cari Nama sales';
                        } else {
                          $value = $lists->NmSales;
                        } ?>
                        <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                        <input type="text" class="form-control-sm" size="20" id="KdSales" onclick="this.select()" name="KdSales" value="<?php echo $faktur->KdSales ?>" required placeholder="Ketik Kode / Nama Sales">
                        <input type="text" class="form-control-sm" disabled id="nm_sales" name="nm_sales" value="<?php echo $value ?>" placeholder="Cari Sales">
                      </div>
                    </td>
                  </tr>
                      -->
                  <tr>
                    <th>Operator</th>
                    <td>:&nbsp;<?php echo $faktur->NmUser ?></td>
                  </tr>
                  <tr>
                    <th>Lokasi</th>
                    <td>:&nbsp;<?php echo $faktur->KdLokasi ?></td>
                  </tr>
                  <tr>
                    <th>Tgl/Jam</th>
                    <td><span class="pull-left">:&nbsp;<?php echo date_indo($tgl) ?> <span id="waktu"></span></span></td>
                  </tr>
                </table>

              </div>

            </div><!-- /.row -->
          </div>

        </div>
      </div>
    </div>
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
    $('#KdCust').focus();
    $('#KdCust').autocomplete({
      source: "<?php echo base_url('pesanjualdetail/get_autocomplete_cust/?'); ?>",
      select: function(event, ui) {
        $('[name="NmCust"]').val(ui.item.label);
        $('[name="KdCust"]').val(ui.item.kode);
        $('#KdCust').focus();
      }
    });
  });

  $(document).ready(function() {
    startTime();
    $('#KdSales').focus();
    $('#KdSales').autocomplete({
      source: "<?php echo base_url('pesanjualdetail/get_autocomplete_sales/?'); ?>",
      select: function(event, ui) {
        $('[name="NmSales"]').val(ui.item.label);
        $('[name="KdSales"]').val(ui.item.kode);
        $('#KdSales').focus();
      }
    });
  });

  $(document).ready(function() {
    startTime();
    $('#KdBrg').focus();
    $('#KdBrg').autocomplete({
      source: "<?php echo base_url('pesanjualdetail/get_autocomplete/?'); ?>",
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
        window.top.location.href = "<?php echo base_url('pesanjualdetail/cekbarang/') ?>" + nofak + "/" + kd_barang;
      }
      return false;
    }
  });

  //cari kode customer
  $("#KdCust").keypress(function(e) {
    var kd_cust = $('#KdCust').val();
    var nofak = $('#nofak').val();
    if (e.which == 13) {
      if (kd_cust) {
        window.top.location.href = "<?php echo base_url('pesanjualdetail/cekcust/') ?>" + nofak + "/" + kd_cust;
      }
      return false;
    }
  });

  //cari kode sales
  $("#KdSales").keypress(function(e) {
    var kd_sales = $('#KdSales').val();
    var nofak = $('#nofak').val();
    if (e.which == 13) {
      if (kd_sales) {
        window.top.location.href = "<?php echo base_url('pesanjualdetail/ceksales/') ?>" + nofak + "/" + kd_sales;
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

  // 45 = minus, 43 = plus, 48 smp 57 = 0 smp 9, 37 = persen
  function isDisc(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
      (charCode < 37 || charCode > 57)) {
      return false;
    }
    return true;
  }


  $(function() {
    $('#diskon').priceFormat({
      prefix: '',
      centsLimit: 0,
      thousandsSeparator: '.'
    });
  });
</script>

<footer class="main-footer">
  <div class="col-4" style="float: right;">
    <a href="<?php echo base_url('pesanjualdetail/daftar-pesanjualdetail/') ?>"><button type="button" class="btn btn-primary btn-sm float-right" style="margin-right: 1px;">
        <i class="fas fa-folder fa-lg mr-2"></i>
      </button>
    </a>
    <a onclick="return confirm('Yakin hapus data ini?');" href="<?php echo base_url('pesanjualdetail/hapus-faktur/') . $faktur->NoPesanJual ?>"><button type="button" class="btn btn-secondary btn-sm float-right" style="margin-right: 3px;">
        <i class="fas fa-trash fa-lg mr-2"></i>
      </button>
    </a>
  </div>

</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- Modal satuan -->
<?php foreach ($list->result() as $key) : ?>
  <div class="modal fade" id="modalEditSatuan<?php echo $key->KdBrg ?>" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newSubMenuModalLabel">Edit Satuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?php echo base_url('pesanjualdetail/edit_satuan/') ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="nopesan" name="nopesan" value="<?php echo $key->NoPesanJual ?>" readonly="readonly" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="kdbrg" name="kdbrg" value="<?php echo $key->KdBrg ?>" readonly="readonly" required>
            </div>
            <div class="form-group">
              <input type="number" class="form-control-sm" id="jumlah" onclick="this.select()" name="jumlah" min="0" value="<?php echo $key->Jumlah ?>" required>
            </div>
            <div class="form-group">
              <select class="form-control" name="sat" id="sat" required>
                <option disabled selected value="<?php echo $key->Sat ?>"><?php echo $key->Sat ?></option>
                <?php
                if ($key->Sat_1 <> '') {
                ?>
                  <option value="<?php echo $key->Sat_1 ?>"><?php echo $key->Sat_1 ?></option>
                <?php
                }
                if ($key->Sat_2 <> '') {
                ?>
                  <option value="<?php echo $key->Sat_2 ?>"><?php echo $key->Sat_2 ?></option>
                <?php
                }
                if ($key->Sat_3 <> '') {
                ?><option value="<?php echo $key->Sat_3 ?>"><?php echo $key->Sat_3 ?></option>
                <?php
                }
                if ($key->Sat_4 <> '') {
                ?><option value="<?php echo $key->Sat_4 ?>"><?php echo $key->Sat_4 ?></option>
                <?php
                }
                ?>
              </select>
              <input name="kdbrg_s" type="hidden" id="KdBrg_s" value="<?php echo $key->KdBrg ?>" />
              <input name="nofak_s" type="hidden" id="nofak_s" value="<?php echo $key->NoPesanJual ?>" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach ?>



<!-- modal agree -->
<div class="modal fade" id="modalAgree" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubMenuModalLabel">Login Spv</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="col-10">
        <form action="<?php echo base_url('pesanjualdetail/entry-pesanjualdetail/') . $faktur->NoPesanJual . "/"  ?>" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" id="username" class="form-control" placeholder="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="password" name="password" type="password" required="required" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">

            <!-- /.col -->
            <div class="col-4">
              <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


</body>

</html>