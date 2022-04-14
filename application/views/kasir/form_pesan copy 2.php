  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">

                <div class="col-12">

                  <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                      <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                      <span class="info-box-text"><input type="text" size="4" class="form-control" id="KdCust" name="KdCust" value="<?php echo $faktur->KdCust ?>" required placeholder="Ketik Kode / Nama Cust"></span>
                    </div>
                    <div class="info-box-content">
                      <span class="info-box-number"><input type="text" size="6" readonly class="form-control" id="nm_cust" name="nm_cust" value="<?php echo $faktur->NmCust ?>" placeholder="Cari Customer">
                      </span>
                    </div>
                    <div class="info-box-content">
                      <form action="<?php echo base_url('kasir/edit_jenis_harga/') ?>" method="post">
                        <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                        <select name="jnshrg" class="form-control" size="1" onchange="this.form.submit();">
                          <option hidden><?php echo $faktur->JenisHrg ?></option>
                          <option value="H1">H1</option>
                          <option value="H2">H2</option>
                          <option value="H3">H3</option>
                          <option value="H4">H4</option>
                        </select>
                      </form>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->

                </div>

                <div class="col-12">
                  <input type="hidden" name="nofak" id="nofak" value="<?php echo $faktur->NoPesanJual ?>">
                  <input type="text" class="form-control" id="KdBrg" name="KdBrg" required placeholder="ketik kode atau nama brg">
                  <span><input type="text" readonly class="form-control" id="nm_barang" name="nm_barang" placeholder="Cari Nama Barang"></span>
                  <hr />
                </div>
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> <?php echo $faktur->NoPesanJual ?>&nbsp; | &nbsp;Cust: <?php echo $faktur->NmCust ?>&nbsp;&nbsp;
                    <!--<small class="float-right">Date: <?php echo $faktur->Tanggal ?></small>-->
                    <span class="pull-right"><?php echo date_indo($tgl) ?> <span id="waktu"></span></span>
                  </h4>
                </div>
                <!-- /.col -->
              </div>


              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Isi</th>
                        <th>Sales</th>
                        <!--<th>Total</th>-->
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($list->result() as $key) : ?>
                        <tr>
                          <td><?php echo $no++ ?></td>
                          <td><?php echo $key->KdBrg ?></td>
                          <td><input name="brg" type="hidden" value="<?php echo $key->KdBrg ?>" />
                            <input name="brg" type="text" disabled value="<?php echo $key->NamaBrg ?>" /></td>
                          <td>
                            <form action="<?php echo base_url('kasir/edit_jumlah_beli/') ?>" method="post">
                              <input name="KdBrg_e" type="hidden" id="KdBrg_e" value="<?php echo $key->KdBrg ?>" />
                              <input name="nofak_e" type="hidden" id="nofak_e" value="<?php echo $key->NoPesanJual ?>" />
                              <input style="text-align: center;" name="jml" type="text" id="jml" size="3" onkeypress="return isNumber(event)" value="<?php echo $key->Jumlah ?>" />
                            </form>
                          </td>
                          <td><a class="btn-warning" href="#modalEditSatuan<?php echo $key->KdBrg ?>" data-toggle="modal" title="Edit"><span class="fa fa-edit"></span> <?php echo $key->Sat ?></a>
                          </td>
                          <td>
                            <form action="<?php echo base_url('kasir/edit_harga_jual/') ?>" method="post">
                              <input name="KdBrg_h" type="hidden" id="KdBrg_h" value="<?php echo $key->KdBrg ?>" />
                              <input name="nofak_h" type="hidden" id="nofak_h" value="<?php echo $key->NoPesanJual ?>" />
                              <input style="text-align: center;" name="hrg" type="text" id="hrg" size="7" onkeypress="return isNumber(event)" value="<?php echo number_format($key->Harga, 0, ',', '.') ?>" />
                            </form>
                          </td>

                          <td><?php echo $key->Isi ?></td>
                          <td>
                            <form action="<?php echo base_url('kasir/edit_kdsales/') ?>" method="post">
                              <input name="kdbrg" type="hidden" id="kdbrg" value="<?php echo $key->KdBrg ?>" />
                              <input name="nofak" type="hidden" id="nofak" value="<?php echo $key->NoPesanJual ?>" />
                              <input style="text-align: center;" name="sales" type="text" id="sales" size="3" onkeypress="return isNumber(event)" value="<?php echo $key->KdSales ?>" />
                            </form>
                          </td>
                          <!--<td><strong><?php echo number_format(($key->Harga * $key->Jumlah), 0, ',', '.') ?></strong></td>-->
                          <td><a onclick="return confirm('Yakin hapus data ini?');" href="<?php echo base_url('kasir/hapus-barang-beli/') . $key->NoPesanJual . "/" . $key->KdBrg ?>">
                              <p style="color: red"><i class="fa fa-times"></i></p>
                            </a></td>
                        </tr>
                        <?php
                        $tot_item += $key->Jumlah;
                        $tot_belanja += (($key->Harga * $key->Jumlah) - $key->Disc);
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
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>Qty</th>
                        <th>Subtotal</th>

                      </tr>
                      <tr>
                        <td><?php echo $tot_item ?></td>
                        <td><strong>Rp. <?php echo number_format($tot_belanja, 0, ',', '.') ?></strong></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-6">
                  <form class="form-inline" action="<?php echo base_url('kasir/go_to_simpan/') ?>" method="post">
                    <input type="hidden" name="nofak_bayar" id="nofak_bayar" value="<?php echo $faktur->NoPesanJual ?>">
                    <input type="hidden" name="total_belanja" id="total_belanja" value="<?php echo $tot_belanja ?>">
                    <?php if ($tot_belanja == 0) {
                      $disable = 'disabled';
                    } else {
                      $disable = '';
                    } ?>
                    <button type="submit" <?php echo $disable; ?> class="btn btn-success float-right" style="margin-right: 5px;"><i class="far fa-credit-card"></i> Simpan Pesan</button>
                  </form>
                </div>
                <div class="col-6">
                  <a href="<?php echo base_url('kasir/antrian-pesan/') . $faktur->NoPesanJual . "/"  ?>"><button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                      <i class="fas fa-cart-plus fa-lg mr-2"></i> Antrian Pesan
                    </button></a>
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
        source: "<?php echo base_url('kasir/get_autocomplete/?'); ?>",
        select: function(event, ui) {
          $('[name="KdBrg"]').val(ui.item.kode);
          $('[name="nm_barang"]').val(ui.item.label);
          $('#KdBrg').focus();
        }
      });
    });

    $(document).ready(function() {
      startTime();
      $('#KdCust').focus();
      $('#KdCust').autocomplete({
        source: "<?php echo base_url('kasir/get_autocomplete_cust/?'); ?>",
        select: function(event, ui) {
          $('[name="NmCust"]').val(ui.item.label);
          $('[name="KdCust"]').val(ui.item.kode);
          $('#KdCust').focus();
        }
      });
    });

    // cari kode barang
    $("#KdBrg").keypress(function(e) {
      var kd_barang = $('#KdBrg').val();
      var nofak = $('#nofak').val();
      if (e.which == 13) {
        if (kd_barang) {
          window.top.location.href = "<?php echo base_url('kasir/cekbarang/') ?>" + nofak + "/" + kd_barang;
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
          window.top.location.href = "<?php echo base_url('kasir/cekcust/') ?>" + nofak + "/" + kd_cust;
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

    $(function() {
      $('#diskon').priceFormat({
        prefix: '',
        centsLimit: 0,
        thousandsSeparator: '.'
      });
    });
  </script>
  <!-- Modal -->
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
          <form action="<?php echo base_url('kasir/edit_satuan/') ?>" method="post">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" class="form-control" id="nopesan" name="nopesan" value="<?php echo $key->NoPesanJual ?>" readonly="readonly" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="kdbrg" name="kdbrg" value="<?php echo $key->KdBrg ?>" readonly="readonly" required>
              </div>
              <div class="form-group">
                <select class="form-control" name="sat" id="sat" required>
                  <option disabled selected><?php echo $key->Sat ?></option>
                  <option value="<?php echo $key->Sat_1 ?>"><?php echo $key->Sat_1 ?></option>
                  <?php
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