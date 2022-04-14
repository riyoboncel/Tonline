<pre><?php print_r($dataku); ?></pre>

<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>No jual</th>
            <th>Cust</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($profit->result() as $key) : ?>
            <tr>
                <td style="text-align:center;"><?php echo $no++ ?></td>
                <td style="text-align:left;"><?php echo $key->NoJual ?></td>
                <td style="text-align:left;"><?php echo $key->NamaCust ?></td>
                <td style="text-align:right;"><?php echo number_format($key->SubTotal, 0, ',', '.') ?></td>

            </tr>

        <?php endforeach ?>
    </tbody>

</table>