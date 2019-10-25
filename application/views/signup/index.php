<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>flatlab/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>flatlab/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>flatlab/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>flatlab/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>flatlab/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

        <form class="form-signin" action="<?= base_url(); ?>signup/register" method="POST">
            <h2 class="form-signin-heading">sign up now</h2>
            <div class="login-wrap">
                Email<input type="text" class="form-control" placeholder="Email" autofocus name="txt_email" required>
                Nama<input type="text" class="form-control" placeholder="Username" autofocus name="txt_user" required>
                Password<input type="password" class="form-control" placeholder="Password" name="txt_pass" required>
                Birth Date<input type="date" class="form-control" autofocus name="txt_bd" required>
                Telephone<input type="text" class="form-control" placeholder="Telephone" autofocus name="txt_tel" required>
                Address<input type="text" class="form-control" placeholder="Address" autofocus name="txt_address" required>
                Mode User
                <select name="mode" class="form-control">
                    <option value="0">Buyer</option>
                    <option value="1">Seller</option>
                </select>
                <br><br>
                <button class="btn btn-lg btn-login btn-block" type="submit">Sign Up</button>
                
            

        </div>


      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>flatlab/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>flatlab/js/bootstrap.min.js"></script>


  </body>
</html>
