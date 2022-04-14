<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
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

                    <h5 align="center">Bulan : <?php echo bulan($bulan) . " " . $tahun; ?></h5>

                    <h4 align="center">Rekap Penjualan Perbarang</h4>
                    <div class="col-12 table-responsive">

                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama_barang</th>
                                    <th>Jumlah</th>
                                    <th>Penjualan</th>
                                    <th>Harga_Pokok</th>
                                    <th>Rugi_Laba</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap as $tt => $key) : ?>

                                    <tr>
                                        <td><?php echo $key->KdBrg ?></td>
                                        <td><?php echo $key->NamaBrg ?></td>
                                        <td><?php echo $key->Jumlah ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_jual, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_modal, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_jual - $key->tot_modal, 0, ',', '.') ?></td>
                                    </tr>
                                    <?php
                                    $aa += $key->tot_jual;
                                    $bb += $key->tot_modal;
                                    $ee += $key->tot_jual - $key->tot_modal
                                    ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td style="text-align:center;"><b>Total</b></td>
                                    <td></td>
                                    <td style="text-align:right;"><b><?php echo number_format($aa, 0, ',', '.') ?></b></td>
                                    <td style="text-align:right;"><b><?php echo number_format($bb, 0, ',', '.') ?></b></td>
                                    <td style="text-align:right;background: yellow"><b><?php echo number_format($ee, 0, ',', '.') ?> </b></td>
                                </tr>
                            </tfoot>
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