<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href=<?php echo base_url().'bootstrap/css/bootstrap.css' ?> rel="stylesheet">
    <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; 
      }
      .container {
        width: 300px;
      }

      /* The white background content wrapper */
      .container > .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; 
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

	  .login-form {
		margin-left: 65px;
	  }
	
	  legend {
		margin-right: -50px;
		font-weight: bold;
	  	color: #404040;
	  }

    </style>

</head>
<body>
  <div class="container">
    <div class="content">
      <div class="row">
        <div class="login-form">
          <h2>Login</h2>
          <?php echo validation_errors(); ?>
          <?php echo form_open('verifylogin'); ?>
            <fieldset>
              <div class="clearfix">
                <input type="text" placeholder="RUT" id="username" name="username">
              </div>
              <div class="clearfix">
                <input type="password" placeholder="Contraseña" id="password" name="password">
              </div>
                <input class="btn btn-success" type="submit" value="Entrar">
            </fieldset>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div> <!-- /container -->
</body>
</html>

    