<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Struk Penjualan</title>
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/') ?>/img/favicon.png" />
  <style type="text/css">
    body {
      font-family: Calibri;
      font-size: 8pt;
      color: #000;
    }
  </style>
</head>

<body>
  <table width="250" border="0" align="center">
    <tr>
      <td colspan="4" align="center">
        <font color="#000000" size="+2" style="text-transform:uppercase"></font>
      </td>
    </tr>
    <tr>
      <td><?php echo $faktur->NoPesanJual; ?></td>
      <td colspan="3" align="right"><?php echo date('d-m-Y', strtotime($faktur->Tanggal)) . " " . $faktur->Jam ?></td>
    </tr>
    <tr>
      <td colspan="4">
        <hr />
      </td>
    </tr>
  </table>
  <table width="250" border="0" align="center">
    <?php foreach ($produk->result() as $key) : ?>
      <tr>
        <td>[<?php echo $key->KdBrg ?>]
          <?php if ($key->Disc_per > 0) : ?>
            <i> ~ Disc. <?php echo $key->Disc_per ?> %</i>
          <?php endif ?>
          <br>

          <div style="font-size: 10px;text-transform:uppercase;"><?php echo $key->NamaBrg ?></div>
        </td>
        <td valign="bottom"><?php echo $key->Jumlah ?></td>
        <td valign="bottom">
          <div align="right"><?php echo number_format($key->Harga, 0, ',', '.') ?></div>
        </td>
        <td valign="bottom">
          <div align="right">total</div>
        </td>
      </tr>
      <?php
      $total_item += $key->Jumlah;
      //$subtotal += $key->sub_total_jual;
      ?>
    <?php endforeach ?>
    <tr>
      <td colspan="4">
        <hr />
      </td>
    </tr>
    <tr>
      <td>TOTAL</td>
      <td colspan="2"><?php echo $total_item ?> ITEM</td>
      <td>
        <div align="right">subtotal</div>
      </td>
    </tr>
    <tr>
      <td align="right">DISKON</td>
      <td></td>
      <td colspan="2">
        <div align="right">total disc</div>
      </td>
    </tr>
    <tr>
      <td align="right">GRAND TOTAL</td>
      <td></td>
      <td colspan="2">
        <div align="right"><?php echo number_format($faktur->SubTotal, 0, ',', '.') ?></div>
      </td>
    </tr>
    <tr>
      <td colspan="4" align="center">
        <hr />
        <p>TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
      </td>
    </tr>
  </table>
</body>

</html>