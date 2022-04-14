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

                    <h4 align="center">Rekap Profit Penjualan</h4>
                    <div class="col-12 table-responsive">

                        <table id="example1" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Penjualan</th>
                                    <th>Harga Pokok</th>
                                    <th>Rugi Laba</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap as $tt => $key) : ?>
                                    <?php
                                    $tot_diskon = $key->tot_diskon1 + $diskon[$tt]->tot_diskon2;
                                    $propit = $key->tot_jual - $key->tot_modal;
                                    ?>
                                    <tr>
                                        <td><?php echo date_indo($key->Tanggal) ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_jual, 0, ',', '.') ?></td>
                                        <td style="text-align:right;"><?php echo number_format($key->tot_modal, 0, ',', '.') ?></td>
                                        <!--<td style="text-align:right;"><?php echo number_format($tot_diskon, 0, ',', '.') ?></td>-->
                                        <td style="text-align:right;"><?php echo number_format($propit, 0, ',', '.') ?></td>
                                    </tr>
                                    <?php
                                    $aa += $key->tot_jual;
                                    $bb += $key->tot_modal;
                                    $cc += $tot_diskon;
                                    $ee += $propit;
                                    ?>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align:center;"><b>Total</b></td>
                                    <td style="text-align:right;"><b><?php echo number_format($aa, 0, ',', '.') ?></b></td>
                                    <td style="text-align:right;"><b><?php echo number_format($bb, 0, ',', '.') ?></b></td>
                                    <!--<td style="text-align:right;"><b>Rp <?php echo number_format($cc, 0, ',', '.') ?></b></td>-->
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

<script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url() ?>/assets/js/bootstrap.js"></script>
<script>
    $('#example1').on('click', '.lihat_record', function() {
        var faktur = $(this).data('faktur');
        var url = "<?php echo base_url('laporan_penjualan/reprint_struk/') ?>" + faktur;
        window.open(url, '_blank', 'location=yes,height=400,width=500,scrollbars=yes,status=yes');
    });
</script>