<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="Aplikasi Tumbas Online" />
  <meta name="author" content="Estoh Software" />
  <title>Cetak Nota</title>
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/') ?>/img/favicon.ico" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/tempusdominus-bootstrap-4/css/bootstrap-4.min.css">
</head>

<body>

  <div class="container">
    <div class="col-md-12">
      <div class="invoice">
        <!-- begin invoice-header -->
        <div class="col-md-12">
          <div style="width: 300px;">
            <h4><?php echo $setting->Nama; ?></h4>
            <h5><?php echo $setting->Alamat1; ?></h5>
          </div>
          <div class="invoice-to">
            <h5>Cust: &nbsp;<?php echo $faktur->NamaCust; ?></h5>
            <h6><?php echo $faktur->NoJual; ?>&nbsp;&nbsp;<?php echo $faktur->Tanggal; ?>&nbsp; <?php echo $faktur->Jam; ?></h6>
          </div>
        </div>
        <hr>
        <!-- end invoice-header -->
        <!-- begin invoice-content -->
        <div class="invoice-content">
          <!-- begin table-responsive -->
          <div class="table-responsive">
            <table class="table table-striped table-sm">

              <tbody>
                <?php
                $no = 1;
                foreach ($produk->result() as $key) : ?>
                  <tr>
                    <td>
                      <!--<span class="text-inverse"><?php echo $key->NamaBrg ?></span><br> -->
                      <small><?php echo $no++ ?>).&nbsp;<?php echo $key->NamaBrg ?></small>
                      <small><?php echo number_format($key->Harga - $key->Disc, 0, ',', '.') ?>&nbsp;x&nbsp;<?php echo $key->Jumlah ?>&nbsp;<?php echo $key->Sat ?>&nbsp;=Rp.&nbsp;<?php echo number_format(($key->Harga - $key->Disc) * $key->Jumlah, 0, ',', '.')  ?></small>
                    </td>
                  </tr>

                <?php endforeach ?>
              </tbody>
            </table>
            <hr>
          </div>
          <!-- end table-responsive -->
          <!-- begin invoice-price -->
          <div class="responsive">
            <table>
              <tr>
                <th>Subtotal</th>
                <td>Rp.</td>
                <td><?php echo number_format($faktur->SubTotal, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <th>Bayar</th>
                <td>Rp.</td>
                <td><?php echo number_format($faktur->Bayar, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <th><?php echo $faktur->KetKembali ?></th>
                <td>Rp.</td>
                <td><?php echo number_format($faktur->Kembali, 0, ',', '.') ?></td>
              </tr>

            </table>

          </div>
          <!-- end invoice-price -->

        </div>
        <!-- end invoice-content -->
        <hr>

        <div class="invoice-footer">
          <p class="text-center m-b-5 f-w-600">
            <a href="<?php echo base_url('fakturjual/daftar-fakturjual/') ?>"><input type="button" value="Terima Kasih"> </a>
          </p>

        </div>
        <!-- end invoice-footer -->
      </div>
    </div>
  </div>


  <script type="text/javascript">
    window.print();
  </script>
</body>

</html>