<script type="text/javascript">
        
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
<section id="main-content">
<section class="wrapper">
<div class="container">
    <div class="row">
        
        <?php
        
        $q_data = mysql_query($query_awal_barang);
        $counter = 0;
        while ($row = mysql_fetch_array($q_data)) {
            if($counter%3==0){
                echo "<div class='row'>";
            }
            ?>
        
        <div class="col-md-4 itemmenu">
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
                        <img id="gambar" src="<?php echo base_url(); ?>img/B0001.jpg" class="img-responsive"/>
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