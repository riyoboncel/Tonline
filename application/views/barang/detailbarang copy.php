<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Barang</a></li>
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
                <table class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sat</th>
                            <th>Hrg Jual</th>
                            <th>Hrg Jual 2</th>
                            <th>Hrg Jual 3</th>
                            <th>Hrg Jual 4</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><?php echo $key->Sat_1; ?></td>
                            <td><?php echo $key->HrgJl11; ?></td>
                            <td><?php echo $key->HrgJl12; ?></td>
                            <th><?php echo $key->HrgJl13; ?></th>
                            <th><?php echo $key->HrgJl14; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo $key->Sat_2; ?></td>
                            <td><?php echo $key->HrgJl21; ?></td>
                            <td><?php echo $key->HrgJl22; ?></td>
                            <th><?php echo $key->HrgJl23; ?></th>
                            <th><?php echo $key->HrgJl24; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo $key->Sat_3; ?></td>
                            <td><?php echo $key->HrgJl31; ?></td>
                            <td><?php echo $key->HrgJl32; ?></td>
                            <th><?php echo $key->HrgJl33; ?></th>
                            <th><?php echo $key->HrgJl34; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo $key->Sat_4; ?></td>
                            <td><?php echo $key->HrgJl41; ?></td>
                            <td><?php echo $key->HrgJl42; ?></td>
                            <th><?php echo $key->HrgJl43; ?></th>
                            <th><?php echo $key->HrgJl44; ?></th>
                        </tr>

                    </tbody>

                </table>
            <?php endforeach; ?>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->