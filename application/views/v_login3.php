<!DOCTYPE html>
<html>

<head>
  <title>Login Tonline</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/') ?>/img/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/') ?>/login3/css/style.css">

  <!-- pwa 
  <link rel="manifest" href="<?php echo base_url() ?>/assets/js/manifest.json">-->
  <link rel="apple-touch-icon" href="<?php echo base_url() ?>/assets/images/favicon.png">

</head>

<body>
  <img class="wave" src="<?php echo base_url('assets/') ?>/login3/img/wave.png">
  <div class="container">
    <div class="img">
      <img src="<?php echo base_url('assets/') ?>/login3/img/bg.svg">
    </div>
    <div class="login-content">
      <form action="<?php echo base_url('login/auth') ?>" method="post">
        <img src="<?php echo base_url('assets/') ?>/login3/img/avatar.png">
        <h2 class="title"></h2>
        <div class="input-div one">
          <div class="i">
            <i class="fas fa-user"></i>
          </div>
          <div class="div">
            <h5>Username</h5>
            <input type="text" name="username" id="username" class="input">
          </div>
        </div>
        <div class="input-div pass">
          <div class="i">
            <i class="fas fa-lock"></i>
          </div>
          <div class="div">
            <h5>Password</h5>
            <input type="password" name="password" class="input">
          </div>
        </div>
        <a>Forgot Password?</a>
        <input type="submit" class="btn" value="Login">
      </form>
    </div>
  </div>
  <script type="text/javascript" src="<?php echo base_url('assets/') ?>/login3/js/main.js"></script>
  <script src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.js"></script>
  <script src="<?php echo base_url('assets/') ?>login/script.js"></script>
  <script src="<?php echo base_url('assets/') ?>js/sweetalert.min.js"></script>

  <!--<script src="<?php echo base_url() ?>/assets/js/register.js"></script>-->

  <script>
    $(document).ready(function() {
      document.getElementById("username").focus()
    });
    $('form').attr('autocomplete', 'off');
    var error = "<?php echo $this->session->flashdata('msg'); ?>";
    error && swal(error, {
      buttons: !1,
      timer: 20000
    });
  </script>

</body>

</html>