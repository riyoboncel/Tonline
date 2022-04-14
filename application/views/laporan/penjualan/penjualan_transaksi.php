<!--<link href="<?php echo base_url() ?>/assets/css/bootstrap.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>/assets/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet" />
-->
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
                        <li class="breadcrumb-item active">Pesan Jual</li>
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
                    <div align="center" class="no-print" id="formFilter" style="background-color: #F5F5F5;padding: 4px">
                        <form class="form-inline" action="" method="get">
                            <input type="hidden" name="filter" id="filter" value="ok">
                            <div class="form-group">
                                <label for="a">Tanggal : </label>
                                <select name="a" id="a" class="form-control">
                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                        <option <?php if ($i == $tgl) {
                                                    echo 'selected';
                                                } ?> value="<?php echo sprintf('%02d', $i) ?>"><?php echo sprintf('%02d', $i) ?></option>
                                    <?php } ?>
                                </select>
                                <select name="b" id="b" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option <?php if ($i == $bln) {
                                                    echo 'selected';
                                                } ?> value="<?php echo sprintf('%02d', $i) ?>"><?php echo sprintf('%02d', $i) ?></option>
                                    <?php } ?>
                                </select>
                                <select name="c" id="c" class="form-control">
                                    <?php for ($i = 2016; $i <= date('Y'); $i++) { ?>
                                        <option <?php if ($i == $thn) {
                                                    echo 'selected';
                                                } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pwd"> s/d </label>
                                <select name="d" id="d" class="form-control">
                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                        <option <?php if ($i == $tgl) {
                                                    echo 'selected';
                                                } ?> value="<?php echo sprintf('%02d', $i) ?>"><?php echo sprintf('%02d', $i) ?></option>
                                    <?php } ?>
                                </select>
                                <select name="e" id="e" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option <?php if ($i == $bln) {
                                                    echo 'selected';
                                                } ?> value="<?php echo sprintf('%02d', $i) ?>"><?php echo sprintf('%02d', $i) ?></option>
                                    <?php } ?>
                                </select>
                                <select name="f" id="f" class="form-control">
                                    <?php for ($i = 2016; $i <= date('Y'); $i++) { ?>
                                        <option <?php if ($i == $thn) {
                                                    echo 'selected';
                                                } ?> value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Filter</button>
                            <a href=""><button type="button" class="btn btn-success" onclick="window.print();return false;">Print</button></a>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <h4 align="center">LAPORAN FAKTUR JUAL</h4>

                    <?php if ($filter) : ?>
                        <h5 align="center">TANGGAL : <?php echo date_indo($awal) . " s/d " . date_indo($akhir) ?></h5>
                    <?php else : ?>
                        <h5 align="center">TANGGAL : <?php echo date_indo($tanggal) ?></h5>
                    <?php endif ?>
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Faktur</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Cust</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penjualan->result() as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no++ ?></td>
                                    <td><?php echo $key->NoJual ?></td>
                                    <td><?php echo $key->Tanggal ?></td>
                                    <td><?php echo number_format($key->SubTotal, 0, ',', '.') ?></td>
                                    <td><?php echo $key->NamaCust ?></td>
                                    <td><?php echo $key->NmUser ?></td>
                                    <td align="center"><a href="javascript:void(0);" class="lihat_record" title="Lihat Detail" data-faktur="<?php echo $key->NoJual ?>">Lihat</a></td>
                                </tr>
                                <?php
                                $subtot += $key->SubTotal;
                                //$diskon += $key->diskon;
                                //$grandtot += $key->total_penjualan_sdiskon;
                                //$cash += $key->cash;
                                //$debet += $key->debet;
                                ?>
                            <?php endforeach ?>
                        </tbody>
                        <thead>
                            <tr>
                                <td colspan="3" align="center">Total</td>
                                <td><strong>Rp.&nbsp;<?php echo number_format($subtot, 0, ',', '.') ?></strong> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                    </table>
                    <hr />

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

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