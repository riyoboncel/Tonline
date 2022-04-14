<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                        <li class="breadcrumb-item active">Profit Jual</li>
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
                    <label>Periode Tanggal</label>

                    <form class="form-inline" action="" method="get">
                        <input type="hidden" name="filter" id="filter" value="ok">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="text" name="startdate" class="form-control startdate datetimepicker-input" data-toggle="datetimepicker" data-target=".startdate" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">s/d</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type="text" name="enddate" class="form-control enddate datetimepicker-input" value="" data-toggle="datetimepicker" data-target=".enddate" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <button type="submit">Filter</button>
                            </div>
                        </div>
                    </form>


                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h4 align="center">Laporan Profit</h4>

                    <?php if ($filter) : ?>
                        <h5 align="center">Tanggal : <?php echo date_indo($awal) . " s/d " . date_indo($akhir) ?></h5>
                    <?php else : ?>
                        <h5 align="center">Tanggal : <?php echo date_indo($tanggal) ?></h5>
                    <?php endif ?>
                    <div class="col-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode_Barang</th>
                                    <th>Nama_Barang</th>
                                    <th>Harga_Modal</th>
                                    <th>Harga_Jual</th>
                                    <th>Qty_Terjual</th>
                                    <th>Modal</th>
                                    <th>Pendapatan</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($profit->result() as $key) : ?>
                                    <?php
                                    $jum_tot = $key->jum_item;
                                    $modal = $key->HrgBeli * $jum_tot;
                                    $pendapatan = $key->harga * $jum_tot;
                                    $profit_gross = $pendapatan - $modal;
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $no++ ?></td>
                                        <td style="text-align:left;"><?php echo $key->KdBrg ?></td>
                                        <td style="text-align:left;"><?php echo $key->NamaBrg ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->HrgBeli, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->harga, 0, ',', '.') ?></td>
                                        <td style="text-align:center;"><?php echo $jum_tot ?></td>
                                        <td style="text-align:right;"><?php echo number_format($modal, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($pendapatan, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($profit_gross, 0, ',', '.') ?></td>
                                    </tr>

                                    <?php
                                    $tot_item += $jum_tot;
                                    $tot_modal += $modal;
                                    $tot_pendapatan += $pendapatan;
                                    $tot_profit += $profit_gross;
                                    ?>

                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr style="background: grey;">
                                    <td colspan="5" style="text-align:center;"><b>Total</b></td>
                                    <td style="text-align:center;"><b><?php echo $tot_item ?></b></td>
                                    <td style="text-align:right;"><b><?php echo number_format($tot_modal, 0, ',', '.') ?></b></td>
                                    <td style="text-align:right;"><b><?php echo number_format($tot_pendapatan, 0, ',', '.') ?></b></td>
                                    <td style="text-align:right; background: red"><b><?php echo number_format($tot_profit, 0, ',', '.') ?></b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php
                    $diskonperbarang = $subdiskon->disk1;
                    $diskonakhir = $subdisakhir->diska;
                    $total_diskon = $diskonperbarang + $diskonakhir;
                    ?>
                    <h4>Diskon</h4>
                    <div class="col-12 table-responsive">
                        <table id="tbPenjualan" class="table table-bordered table-striped">
                            <tr>
                                <td>1. Total Diskon (per Barang)</td>
                                <th style="text-align:right;"><?php echo number_format($diskonperbarang, 0, ',', '.') ?></th>
                            </tr>
                            <tr>
                                <td>2. Total Diskon (per Transaksi)</td>
                                <th style="text-align:right;"><?php echo number_format($diskonakhir, 0, ',', '.') ?></th>
                            </tr>
                            <tr>
                                <th style="text-align:left">Total Diskon</th>
                                <th style="text-align:right;background: red;color: white; width: 7em"><?php echo number_format($total_diskon, 0, ',', '.') ?></th>
                            </tr>
                        </table>
                    </div>


                    <?php
                    $laba_bersih = $tot_profit - $totbiaya - $total_diskon;
                    ?>
                    <div class="col-12 table-responsive">
                        <table id="tbPenjualan" class="table table-bordered table-striped">
                            <tr>
                                <?php if ($filter) : ?>
                                    <th style="text-align:left; font-size: 16px">Laba Bersih Tanggal <?php echo date_indo($awal) . " s/d " . date_indo($akhir) ?></th>
                                <?php else : ?>
                                    <th style="text-align:left; font-size: 16px">Laba Bersih Tanggal <?php echo date_indo($tanggal) ?></th>
                                <?php endif ?>

                            </tr>
                            <tr>
                                <th style="text-align:right;background: yellow; font-size: 16px;">Rp. <?php echo number_format($laba_bersih, 0, ',', '.') ?>,-</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


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

<script src="<?php echo base_url() ?>/assets/js/custom.rangedate.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        setDateRangePicker(".startdate", ".enddate")
    })
</script>