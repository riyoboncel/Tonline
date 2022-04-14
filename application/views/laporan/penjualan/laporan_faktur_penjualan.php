<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
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

                    <h4 align="center">LAPORAN FAKTUR JUAL</h4>

                    <?php if ($filter) : ?>
                        <h5 align="center">TANGGAL : <?php echo date_indo($awal) . " s/d " . date_indo($akhir) ?></h5>
                    <?php else : ?>
                        <h5 align="center">TANGGAL : <?php echo date_indo($tanggal) ?></h5>
                    <?php endif ?>
                    <div class="col-12 table-responsive">
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
                                        <td><?php echo number_format($key->SubTotal, 0, '.', ',') ?></td>
                                        <td><?php echo $key->NamaCust ?></td>
                                        <td><?php echo $key->NmUser ?></td>
                                        <td align="center"><a href="javascript:void(0);" class="lihat_record" title="Lihat Detail" data-faktur="<?php echo $key->NoJual ?>">Lihat</a></td>
                                    </tr>

                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
<script>
    $(function() {
        $("#example1").DataTable({
            "aLengthMenu": [
                [10, 25, 50, 75, -1],
                [10, 25, 50, 75, "All"]
            ],
            "pageLength": 10,
            "language": {
                "search": "Cari",
                "info": "Menampilkan _START_ Sampai _END_ Dari _TOTAL_ data",
                "lengthMenu": "Menampilkan _MENU_ baris",
                "infoEmpty": "Tidak ditemukan",
                "infoFiltered": "(pencarian dari _MAX_ data)",
                "zeroRecords": "Data tidak ditemukan",
                "paginate": {
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya",
                }
            },
            "responsive": true,
            "autoWidth": false,

            /* untuk sum footer callback */
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(3)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(3, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html(
                    'Rp ' + pageTotal
                );
            }


        });

    });
</script>