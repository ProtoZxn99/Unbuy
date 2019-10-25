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

    <script src="<?php echo base_url(); ?>flatlab/js/jquery.js"></script>
    <script type="text/javascript">
        
        function proses(){
            var user = document.getElementById('txt_user').value;
            var email = document.getElementById('txt_email').value;
            var pass1 = document.getElementById('txt_pass').value;
            var pass2 = document.getElementById('txt_pass2').value;
            
            if(user === ""){
                alert("User tidak boleh kosong");
            }else if(email === ""){
                alert("Email tidak boleh kosong");
            }else if(pass1 === ""){
                alert("Password tidak boleh kosong");
            }else if(pass2 === ""){
                alert("Password ");
            }else{
                if(pass1 === pass2){
                    $.ajax({
                        url : "<?php echo base_url(); ?>signup/process1",
                        type: "POST",
                        data: $('#form').serialize(),
                        dataType: "JSON",
                        success: function(data){
                            if(data.status === "Data tersimpan"){
                                alert(data.status);
                                window.location.href = "<?php echo base_url(); ?>home";
                            }else{
                                alert(data.status);
                            }
                        },error: function (jqXHR, textStatus, errorThrown){
                            alert("Error json " + errorThrown);
                        }
                    });
                }else{
                    alert("Password doesn't match");
                }
            }   
        }
        
    </script>
</head>

  <body class="login-body">
    <div class="container">
       
        <div class="login-wrap form-signin">
            <h2 class="form-signin-heading">sign up now</h2>
            <form id="form" >
                Name*<input type="text" class="form-control" placeholder="User ID" autofocus name="txt_user" id="txt_user">

                Email*<input type="email" class="form-control" placeholder="Email" autofocus name="txt_email" id="txt_email">

                Password*<input type="password" class="form-control" placeholder="Password" name="txt_pass" id="txt_pass">

                Confirm Password*<input type="password" class="form-control" placeholder="Password" name="txt_pass2" id="txt_pass2">

                Telephone<input type="text" class="form-control" placeholder="Telephone" autofocus name="txt_tel" id="txt_tel">

                Address<input type="text" class="form-control" placeholder="Address" autofocus name="txt_address" id="txt_address">
            </form>          
            <button class="btn btn-lg btn-login btn-block" type="button" onclick="proses()">Sign Up</button>
            <br>
            <p align="center">*required</p>
        </div>
      

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>flatlab/js/bootstrap.min.js"></script>


  </body>
</html>
