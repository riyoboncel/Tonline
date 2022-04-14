<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('barang/') ?>">Barang</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
            <?php foreach ($barang->result() as $key) : ?>
                Kode: &nbsp;<?php echo $key->KdBrg; ?><br>
                Nama: &nbsp;<?php echo $key->NmBrg; ?>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sat</th>
                                <th></th>
                                <th>H1</th>
                                <th>H2</th>
                                <th>H3</th>
                                <th>H4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- satuan 1 -->
                            <tr>
                                <td><?php echo $key->Sat_1; ?></td>
                                <td></td>
                                <td><?php echo $key->HrgJl11; ?></td>
                                <td><?php echo $key->HrgJl12; ?></td>
                                <td><?php echo $key->HrgJl13; ?></td>
                                <td><?php echo $key->HrgJl14; ?></td>
                            </tr>
                            <!-- satuan 2 -->
                            <tr>
                                <td><?php echo $key->Sat_2; ?></td>
                                <td><?php echo $key->Isi_2; ?></td>
                                <td><?php echo $key->HrgJl21; ?></td>
                                <td><?php echo $key->HrgJl22; ?></td>
                                <td><?php echo $key->HrgJl23; ?></td>
                                <td><?php echo $key->HrgJl24; ?></td>
                            </tr>
                            <!-- satuan 3 -->
                            <tr>
                                <td><?php echo $key->Sat_3; ?></td>
                                <td><?php echo $key->Isi_3; ?></td>
                                <td><?php echo $key->HrgJl31; ?></td>
                                <td><?php echo $key->HrgJl32; ?></td>
                                <td><?php echo $key->HrgJl33; ?></td>
                                <td><?php echo $key->HrgJl34; ?></td>
                            </tr>
                            <!-- satuan 4 -->
                            <tr>
                                <td><?php echo $key->Sat_4; ?></td>
                                <td><?php echo $key->Isi_4; ?></td>
                                <td><?php echo $key->HrgJl41; ?></td>
                                <td><?php echo $key->HrgJl42; ?></td>
                                <td><?php echo $key->HrgJl43; ?></td>
                                <td><?php echo $key->HrgJl44; ?></td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            <?php endforeach; ?>
            <!-- /.row (main row) -->
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ?>/assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/dist/js/demo.js"></script>