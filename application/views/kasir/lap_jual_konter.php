<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Lap. Jual Konter</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Penjualan</a></li>
                        <li class="breadcrumb-item active">Lap. Jual Konter</li>
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
                    <h3 class="card-title"><a href="<?php echo base_url('kasir/nomor-faktur/') ?>"><button type="button" class="btn btn-block bg-gradient-primary"><i class="fas fa-cart-plus fa-lg mr-2"></i>Pesan Baru</button></a></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Pesan</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nm Barang</th>
                                <th>Pesan</th>
                                <th>Jual</th>
                                <th>Batal</th>
                                <th>Pending</th>
                                <th>Satuan</th>
                                <th>Customer</th>
                                <th>Hrg Cust</th>
                                <th>KD Sales</th>
                                <th>Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($selesai->result() as $key) : ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $key->NoPesanJual ?></td>
                                    <td><?php echo date_indo($key->Tanggal) ?></td>
                                    <td><?php echo $key->KdBrg ?></td>
                                    <td><?php echo $key->Nama_Barang ?></td>
                                    <td><?php echo $key->Pesan ?></td>
                                    <td><?php echo $key->Jual ?></td>
                                    <td><?php echo $key->Batal ?></td>
                                    <td><?php echo $key->Pending ?></td>
                                    <td><?php echo $key->Sat ?></td>
                                    <td><?php echo $key->NmCust ?></td>
                                    <td><?php echo $key->HrgCust ?></td>
                                    <td><?php echo $key->KdSales ?></td>
                                    <td><?php echo $key->NmUser ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>