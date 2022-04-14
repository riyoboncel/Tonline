<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) class row -->
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" action="<?php echo base_url('rekap_jual/rekap_penjualan_perbarang/') ?>" method="post">
                        <input type="hidden" name="filter" id="filter" value="ok">
                        <div class="form-group">
                            <label for="pwd" style="width: 100px">Bulan : </label>
                            <select name="bulan" id="bulan" class="form-control" required>
                                <option value="">Pilih Bulan</option>
                                <option <?php if ($bulan == '01') {
                                            echo 'selected';
                                        } ?> value="01">Januari</option>
                                <option <?php if ($bulan == '02') {
                                            echo 'selected';
                                        } ?> value="02">Februari</option>
                                <option <?php if ($bulan == '03') {
                                            echo 'selected';
                                        } ?> value="03">Maret</option>
                                <option <?php if ($bulan == '04') {
                                            echo 'selected';
                                        } ?> value="04">April</option>
                                <option <?php if ($bulan == '05') {
                                            echo 'selected';
                                        } ?> value="05">Mei</option>
                                <option <?php if ($bulan == '06') {
                                            echo 'selected';
                                        } ?> value="06">Juni</option>
                                <option <?php if ($bulan == '07') {
                                            echo 'selected';
                                        } ?> value="07">Juli</option>
                                <option <?php if ($bulan == '08') {
                                            echo 'selected';
                                        } ?> value="08">Agustus</option>
                                <option <?php if ($bulan == '09') {
                                            echo 'selected';
                                        } ?> value="09">September</option>
                                <option <?php if ($bulan == '10') {
                                            echo 'selected';
                                        } ?> value="10">Oktober</option>
                                <option <?php if ($bulan == '11') {
                                            echo 'selected';
                                        } ?> value="11">November</option>
                                <option <?php if ($bulan == '12') {
                                            echo 'selected';
                                        } ?> value="12">Desember</option>
                            </select>
                        </div> <br><br>
                        <div class="form-group">
                            <label for="email" style="width: 100px">Tahun : </label>
                            <select name="tahun" id="tahun" class="form-control" required>
                                <option value="">Pilih Tahun</option>
                                <?php foreach ($year as $key) : ?>
                                    <option value="<?php echo $key['thn'] ?>"><?php echo $key['thn'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div><br><br>
                        <div style="margin-left: 100px">
                            <button type="submit" id="btnSimpanBiaya" class="btn btn-success">Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 align="center">Bulan : <?php echo bulan($bulan) . " " . $tahun; ?></h5>
                    <h6 align="center">Rekap Penjualan Perbarang</h6>
                    <div class="col-12 table-responsive">

                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama_barang</th>
                                    <th>Jumlah</th>
                                    <th>Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap as $tt => $key) : ?>
                                    <tr>
                                        <td><?php echo $key->KdBrg ?></td>
                                        <td><?php echo $key->NamaBrg ?></td>
                                        <td><?php echo $key->Jumlah ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_jual, 0, ',', '.') ?></td>
                                    </tr>
                                    <?php
                                    $aa += $key->tot_jual;
                                    ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td style="text-align:center;"><b>Total</b></td>
                                    <td></td>
                                    <td style="text-align:right;"><b><?php echo number_format($aa, 0, ',', '.') ?></b></td>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>

<!-- jQuery -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

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
</script>