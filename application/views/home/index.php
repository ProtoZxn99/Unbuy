<script type="text/javascript">
    
    $(function(){
        <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $q_item = mysql_query("select count(item_id) from item where item_id = '".$id."';");
            $stock = mysql_fetch_array($q_item);
            if($stock[0]>0){
        ?>
                detail('<?= $id ?>');
        <?php
            }
        }
        ?>
    });
    
    function detail(id){
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text(id); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>search/detail/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                $('[id=form_id]').val(data.item_id);
                $('[id=item_id]').text(data.item_id);
                $('[id=item_seller]').text(data.user_name);
                $('[id=item_name]').text(data.item_name);
                $('[id=item_text]').text(data.item_text);
                $('[id=item_price]').text("IDR "+data.item_price);
                $('[id=form_quantity]').val(data.qty);
                $('[id=form_quantity]').attr("max",data.item_stock);
                
                $.ajax({
                    url : "<?php echo base_url(); ?>search/gambar/" + data.item_id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data1){
                        //alert(data1.status1);
                        $('[id=gambar]').attr("src",data1.status1);
                    },error: function (jqXHR, textStatus, errorThrown){
                        alert('Error get data');
                    }
                });
                $('[id=gambar]').attr("width","");
            },error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }
    
    function cart(){
        $.ajax({
            url : "<?php echo base_url(); ?>search/cart",
            type: "POST",
            data: $('#form').serialize(),
            success: function(data){
                location.reload();
            },error: function (jqXHR, textStatus, errorThrown){
                location.reload();
            }
        });
            }
</script>
<!--main content start-->
      <section id="main-content">
          
          
          
          <section class="wrapper">
              
           
              <!-- search -->
              <div class="container">
                  <div class="row">
                      <div class="row">
                  <div class="col-md-12">
                      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                          <?php
                          $q_jml_slider = mysql_query("SELECT count(*) as jml FROM promo;");
                          $jml_slider = mysql_fetch_array($q_jml_slider)['jml'];
                          ?>
                          <ol class="carousel-indicators">
                              <?php
                              for($i=0; $i<$jml_slider; $i++){
                                  if($i==0){
                                      ?>
                              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" class="active"></li>
                                      <?php
                                  }else{
                                      ?>
                              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>"></li>
                                      <?php
                                  }
                              }
                              ?>
                          </ol>
                          <div class="carousel-inner" role="listbox">
                              <?php
                              $counter = 0;
                              $q_slider = mysql_query("SELECT * FROM promo;");
                              while ($row1 = mysql_fetch_array($q_slider)) {
                                  if($counter == 0){
                                      ?>
                              <div class="item active">
                                  <img src="<?php echo $row1['promo_image']; ?>" style="width: 100%; height: 300px; object-fit: cover;" alt="First slide">
                                  <div class="carousel-caption">
                                        <?= $row1['promo_name'];?>
                                      </div>
                              </div>
                                      <?php
                                  }else{
                                      ?>
                              <div class="item">
                                  <img src="<?php echo $row1['promo_image']; ?>" style="width: 100%; height: 300px; object-fit: cover;" alt="Second slide">
                                  <div class="carousel-caption">
                                        <?= $row1['promo_name'];?>
                                      </div>
                              </div>
                                      <?php
                                  }
                                  $counter++;
                              }
                              ?>
                          </div>
                          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                          </a>
                      </div>
                  </div>
              </div>
              <!--state overview start-->
              <?php
              if($level == 2){
                  ?>
              <div class="row state-overview">
                  
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $jml_user; ?>
                              </h1>
                              <p>Users</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="icon-tags"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $nama_user; ?>
                              </h1>
                              <p>Pembeli Loyal</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="icon-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1 style="font-size: 22px;">
                                  <?php echo $penjual; ?>
                              </h1>
                              <p>Best Seller</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="icon-bar-chart"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $jml_trans; ?>
                              </h1>
                              <p>total Transactions</p>
                          </div>
                      </section>
                  </div>
              </div>
                  <?php
              }
              ?>
              <!--state overview end-->

              <div class="row">
                 <div class="revenue-head">
                        <span>
                            <i class="icon-bar-chart"></i>
                        </span>
                        <h3>Home</h3>
                    </div>
              </div>
                  </div>
    <div class="row">
        
        <?php
        
        $q_data = mysql_query($query_awal_barang);
        $counter = 0;
        while ($row = mysql_fetch_array($q_data)) {
            if($counter%3==0){
                echo "<div class='row'>";
            }
            ?>
        
        <div class="col-md-4">
            <div class="thumbnail">
                <?php
                    if(strlen($row['item_photo']) > 0){
                        echo '<img src="data:image/jpg;base64,'.$row['item_photo'].'" class="img-thumbnail" style="height: 200px; width: auto;">';
                    }else{
                        ?>
                <img src="<?php echo base_url();?>img/B0001.jpg" class="img-thumbnail" style="height: 200px; width: auto;">
                        <?php
                    }
                ?>
                <div class="caption" style="height: 200px; overflow: hidden;">
                    <h4 class="pull-right"><?php echo 'IDR '.$row['harga']; ?></h4>
                    <h4 onclick="detail('<?= $row['item_id']; ?>','<?= $row['item_name']; ?>');" style="cursor: pointer; color: lightskyblue;"><?php echo $row['item_name']; ?></h4>
                    <p>
                        <?php 
                        if(strlen($row['item_text']) > 200){
                            echo substr($row['item_text'], 0, 200).'....'; 
                        }else{
                            echo substr($row['item_text'], 0, 200); 
                        }
                        ?>
                    </p>
                </div>
                
                <div class="space-ten"></div>
                <div class="btn-ground text-center">
                    <button onclick="detail('<?= $row['item_id']; ?>','<?= $row['item_name']; ?>');" type="button" class="btn btn-primary" data-toggle="modal" data-target="#product_view">
                        <i class="fa fa-search"></i> 
                        Detail
                    </button>
                </div>
                <div class="space-ten"></div>
            </div>
        </div>
            <?php
            if($counter%3==2){
                echo "</div>";
            }
            $counter++;
        }
        ?>
        
    </div>
</div>
<div class="modal fade product_view" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title" id="item_name">Items's Name</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12 product_img">
                        <p align="center">
                        <img id="gambar" src="<?php echo base_url(); ?>img/B0001.jpg" class="img-responsive"/>
                        </p>
                    </div>
                    <div class="col-md-12 col-xs-12 product_content">
                        <h4>Product Id: <span id = "item_id"></span></h4>
                        <h4>Seller Name: <span id = "item_seller"></span></h4>
                        <p id="item_text"><span id = "item_text"></span></p>
                        <h3 class="cost" id="item_price"></h3>
                            <div>
                                <form id="form">
                                    <input type="hidden" id="form_id" name="form_id">
                                    <input type='number' id='form_quantity' name='form_quantity' min=0 max=1>
                                </form>
                            </div>
                        <div class="space-ten"></div>
                        <div class="btn-ground">
                            <br>
                            <button type="button" class="btn btn-primary" onclick="cart();">
                                <span class="glyphicon glyphicon-shopping-cart"></span> 
                                Add To Cart
                            </button>
                        </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
              
          </section>
      </section>
      <!--main content end-->
