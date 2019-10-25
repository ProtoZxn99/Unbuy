<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>UNBUY - to buy or not to buy?</title>

    <!-- Bootstrap core CSS -->
    
    <link href="<?php echo base_url(); ?>flatlab/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>flatlab/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>flatlab/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>flatlab/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>flatlab/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>flatlab/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>flatlab/css/style-responsive.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>flatlab/css/custom.css" rel="stylesheet">
    
    <script src="<?php echo base_url(); ?>flatlab/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>flatlab/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>flatlab/js/jquery-1.12.3.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.js"></script>
    
    <!-- Tanggal -->
    <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/highcharts/modules/exporting.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/highcharts/themes/skies.js"></script>
    <script type="text/javascript">
            
            function back(){
                window.history.back();
            }
            
            function hanyaAngka(e, decimal) {
                var key;
                var keychar;
                if (window.event) {
                    key = window.event.keyCode;
                } else if (e) {
                    key = e.which;
                } else {
                    return true;
                }
                keychar = String.fromCharCode(key);
                if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
                    return true;
                } else if ((("0123456789").indexOf(keychar) > -1)) {
                    return true;
                } else if (decimal && (keychar == ".")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
  </head>
<body>
  <?php 
    if(session_id() == '') {
        session_start();
    }
  ?>
  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="<?= base_url();?>" class="logo">Un<span>BUY</span></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    
                    <!-- notification dropdown start-->
                    <li id="header_notification_bar" class="dropdown">
                        <?php
                        if(isset($user)){
                        if($level == 2){
                            $q_uncon = mysql_query("select count(*) jml from webtransaction where trans_status = 'unconfirmed';");
                            $jml_uncon = mysql_fetch_array($q_uncon)['jml'];
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning"><?php echo $jml_uncon; ?></span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have <?php echo $jml_uncon; ?> new notifications</p>
                            </li>
                            <?php
                            $q_unconfirmed = mysql_query("select trans_id, trans_date from webtransaction where trans_status = 'unconfirmed' order by trans_date desc;");
                            while ($row = mysql_fetch_array($q_unconfirmed)) {
                                ?>
                            <li>
                                <a href="<?php echo base_url(); ?>transaction">
                                    <span class="label label-warning"><i class="icon-bell"></i></span>
                                    <?php echo $row['trans_id'].', '.$row['trans_date']; ?>.
                                </a>
                            </li>    
                                <?php
                            }
                            ?>
                            
                        </ul>
                            <?php
                        }else if($level == 1){
                            //$q_uncon = mysql_query("select count(distinct(trans_id)) as jml from transaction_item where seller_id = '".$user."' and trans_id = (select trans_id FROM webtransaction where trans_status = 'confirmed');");
                            $q_uncon = mysql_query("select count(distinct(i.trans_id)) as jml from transaction_item i, webtransaction w where i.seller_id = '".$user."' and w.trans_status = 'confirmed';");
                            if($q_uncon == false){
                                $q_uncon = 0;
                            }
                            else{
                                $jml_uncon = mysql_fetch_array($q_uncon)['jml'];
                            }
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning"><?php echo $jml_uncon; ?></span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have <?php echo $jml_uncon; ?> new notifications</p>
                            </li>
                            <?php
                            //$q_unconfirmed = mysql_query("select distinct(trans_id) as trans_id from transaction_item where seller_id = '".$user."' and trans_id = (select trans_id FROM webtransaction where trans_status = 'confirmed');");
                            $q_unconfirmed = mysql_query("select distinct(i.trans_id) as trans_id from transaction_item i, webtransaction w where i.seller_id = '".$user."' and w.trans_status = 'confirmed';");
                            while ($row = mysql_fetch_array($q_unconfirmed)) {
                                ?>
                            <li>
                                <a href="<?php echo base_url(); ?>transactionsend">
                                    <span class="label label-warning"><i class="icon-bell"></i></span>
                                    <?php echo $row['trans_id']; ?>.
                                </a>
                            </li>    
                                <?php
                            }
                            ?>
                        </ul>
                            <?php
                        }else if($level == 0){
                            $q_uncon = mysql_query("select count(*) as jml from webtransaction where trans_status = 'sending' and buyer_id = '".$user."';");
                            $jml_uncon = mysql_fetch_array($q_uncon)['jml'];
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning"><?php echo $jml_uncon; ?></span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have <?php echo $jml_uncon; ?> new notifications</p>
                            </li>
                            <?php
                            $q_unconfirmed = mysql_query("select trans_id from webtransaction where trans_status = 'sending' and buyer_id = '".$user."';");
                            while ($row = mysql_fetch_array($q_unconfirmed)) {
                                ?>
                            <li>
                                <a href="<?php echo base_url(); ?>transactionterima">
                                    <span class="label label-warning"><i class="icon-bell"></i></span>
                                    <?php echo $row['trans_id']; ?>.
                                </a>
                            </li>    
                                <?php
                            }
                            ?>
                        </ul>
                            <?php
                        }else{
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning">0</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have 0 new notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="icon-bell"></i></span>
                                    Server #10 not respoding.
                                    <span class="small italic">1 Hours</span>
                                </a>
                            </li>    
                        </ul>
                            <?php
                        }
                        }
                        else{
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning">0</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <a href="<?= base_url()?>login">
                            <li>
                                <p class="yellow">Sign in to view notifications</p>
                            </li>
                            </a>
                        </ul>
                        <?php
                        }
                        ?>
                    </li>
                    <!-- notification dropdown end -->
                    
                    <!-- inbox dropdown start-->
                    
                    <!-- inbox dropdown end -->
                    
                    
                    <!-- settings start -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="<?= base_url();?>cart">
                            <i class="icon-shopping-cart"></i>
                            <span class="badge bg-success">
                                <?php
                                if(isset($_SESSION['cart'])){
                                    echo count($_SESSION['cart']); 
                                }
                                else{
                                    echo '0';
                                }
                                ?>
                            </span>
                        </a>
                    </li>
                    
                    
                    <!-- settings end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                
                <ul class="nav pull-right top-menu">
                    <li class="dropdown">
                        <form action="<?php echo base_url(); ?>search/item" method="POST">
                            <input type="text" class="form-control search" placeholder="Search" name="pencarian">
                        </form>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <?php
                        if(strlen($name) > 0){
                            ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <?php
                            $q_img = mysql_query("SELECT user_photo FROM webuser where user_name = '".$name."';");
                            $data_img = mysql_fetch_array($q_img);
                            
                            if(strlen($data_img['user_photo']) > 0){
                                echo '<img src="data:image/jpg;base64,'.$data_img['user_photo'].'" style="height: 32px; width: 32px;">';
                            }else{
                                ?>
                            <img src="<?= base_url(); ?>img/default.jpg" style="width: 32px; height: 32px;">
                                <?php
                            }
                            
                            ?>
                            <span class="username">
                                <?= $name; ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>&nbsp;</li>
                            <li><a href="<?php echo base_url(); ?>profile"><i class=" icon-suitcase"></i>Profile</a></li>
                            <li>&nbsp;</li>
                            <li><a href="<?= base_url(); ?>home/logout"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                            <?php
                        }else{
                            ?>
                                    <li class="dropdown">
                                <a class="dropdown-toggle" href="<?= base_url();?>login">
                                    <img alt="" src="img/default.jpg" style="height: 32px; width: 32px;">
                                    <span class="username">Sign In</span>
                                </a>
                            </li>
                            
                            <?php
                        }
                        ?>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>