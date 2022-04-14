<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12 ">
          <!-- Main content -->
          <div class="invoice p-3 mb-2">
            <!-- title row -->
            <div class="row">
              <span class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cek Harga Jual (<?php echo date_indo($tgl) ?>) <span id="waktu"></span></span>

            </div>
            <!--
            <div class="col-12">
              <div class="input-group">
                <input type="hidden" name="nofak" id="nofak" value="">
                <input type="text" class="form-control" id="KdBrg" name="KdBrg" required placeholder="ketik kode, barcode atau nama brg">
                <input type="hidden" readonly class="form-control" id="nm_barang" name="nm_barang">
                <div class="input-group-prepend">
                  <div class="input-group-text" id="btnGroupAddon2"><i class="fas fa-search"></i></div>
                </div>
              </div>
            </div>
-->
          </div>

          <div class="invoice p-3 mb-2">
            <!-- Table row -->
            <h1>Live Data Search</h1>
            Pencarian
            <input type="text" name="search_text" id="search_text" autofocus="" placeholder="Nama Siswa/ NIS">
            <br><br>

            <div id="result"></div>

            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
              load_data();

              function load_data(query) {
                $.ajax({
                  url: "<?php echo base_url('barang/fetch'); ?>",
                  method: "POST",
                  data: {
                    query: query
                  },
                  success: function(data) {
                    $('#result').html(data);
                  }
                })
              }

              $('#search_text').keyup(function() {
                let search = $(this).val();
                let len_text = search.length;
                if (len_text > 0) {
                  load_data(search);
                } else {
                  $("#result").html("");
                }
              });
            </script>

          </div>
        </div>

      </div><!-- /.col -->
    </div><!-- /.row -->