<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login User : Estoh Software Development</title>
  <!-- Meta-Tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <meta name="keywords" content="pesan jual web, tumbasus,estoh software, tumbas online" />
  <!--<script type="module" src="https://cdn.jsdelivr.net/npm/@pwabuilder/pwainstall@latest/dist/pwa-install.min.js"></script>-->
  <script>
    addEventListener(
      "load",
      function() {
        setTimeout(hideURLbar, 0);
      },
      false
    );

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <!-- //Meta-Tags -->
  <!-- Stylesheets -->
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/') ?>/img/favicon.ico" />
  <link href="<?php echo base_url('assets/') ?>/login2/css/font-awesome.css" rel="stylesheet" />
  <link href="<?php echo base_url('assets/') ?>/login2/css/style.css" rel="stylesheet" type="text/css" />
  <!--// Stylesheets -->
  <!--fonts-->
  <!-- title -->
  <!-- body -->
  <!-- <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext" rel="stylesheet" />fonts -->
</head>

<body>
  <h1>.</h1>
  <div class="w3ls-login box box--big">
    <!-- form starts here -->
    <form action="<?php echo base_url('login/auth') ?>" method="post">
      <div class="agile-field-txt">
        <label>
          <i class="fa fa-user" aria-hidden="true"></i> Username
        </label>
        <input type="text" name="username" placeholder="Enter your name " required="" />
      </div>
      <div class="agile-field-txt">
        <label>
          <i class="fa fa-envelope" aria-hidden="true"></i> password
        </label>
        <input type="password" name="password" placeholder="Enter your password " required="" id="myInput" />
        <div class="agile_label">
          <input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()" />
          <label class="check" for="check3">Show password</label>
        </div>
      </div>
      <!-- script for show password -->
      <script>
        function myFunction() {
          var x = document.getElementById("myInput");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
      </script>
      <!-- //script ends here -->
      <div class="w3ls-bot">
        <div class="form-end">
          <input type="submit" value="LOGIN" />
        </div>
        <div class="clearfix"></div>
      </div>
    </form>
  </div>
  <!-- //form ends here -->
  <!--copyright-->
  <div class="copy-wthree">
    <p>
      &copy; Copyright <?php echo date('Y') ?> | Design by
      <a href="http://estoh.id/" target="_blank">Estoh Software</a>
    </p>
  </div>
  <!--//copyright-->
  <script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.js"></script>
  <script src="<?php echo base_url('assets/') ?>login/script.js"></script>
  <script src="<?php echo base_url('assets/') ?>js/sweetalert.min.js"></script>
  <script>
    $(document).ready(function() {
      document.getElementById("username").focus()
    });
    $('form').attr('autocomplete', 'off');
    var error = "<?php echo $this->session->flashdata('msg'); ?>";
    error && swal(error, {
      buttons: !1,
      timer: 5e3
    });
  </script>
</body>

</html>