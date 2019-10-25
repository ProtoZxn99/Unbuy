<script type="text/javascript">

    function setcart(id){
        var id = $("#"+id).attr("id");
        var qty =$("#"+id).val();

        if(qty == null){
            qty = 0;
        }
        $.ajax({
            url : "<?php echo base_url(); ?>cart/setcart/" + id+"/"+qty,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                location.reload();
            },error: function (jqXHR, textStatus, errorThrown){
                location.reload();
            }
        });
    }
    
    function cek_login_as_buyer(){
        $.ajax({
            url : "<?php echo base_url(); ?>cart/cek_login_as_buyer",
            type: "POST",
            dataType: "JSON",
            success: function(data){
                if(data.status === 'ok'){
                    window.location.href = "<?php echo base_url(); ?>payment";
                }else{
                    alert(data.status);
                }
            },error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
            }
        });
    }
    
</script>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="padding:15px;background-color:#FCB322;color:white;border-radius:15px;">
                <img src="<?php echo base_url();?>img/shopping.png" style="height:60px;width:60px;margin-top:-20px;">
                    <span style=" font-family:'times new roman'; font-size:28pt;">CART</span>
            </div>
            <div class="col-md-1"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-11" style="background-color:#ff6c60;height:4px;margin-left:3.5%;">
            </div>
        </div>
        <br>
        <?php
        $total = 0;
        if(isset($_SESSION['cart'])){
        if(count($_SESSION['cart']) > 0){
           
           
            foreach ($_SESSION['cart'] as $item => $qty) {
                $qd = mysql_query("SELECT * FROM item where item_id = '".$item."';");
                $detail = mysql_fetch_assoc($qd);
                $subtotal = ($detail['item_price']*$qty);
                $total += $subtotal;
                ?>
                <div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10" >
                            <div class="row">
                                <div class="col-md-4" style="height:200px; padding-top:10px;">
                                    <?php
                                        if(strlen($detail['item_photo']) > 0){
                                            echo '<img src="data:image/jpg;base64,'.$detail['item_photo'].'" style="height: 180px; width: 180px;">';
                                        }else{
                                            ?>
                                            <img src="<?php echo base_url();?>img/B0001.jpg" style="height:180px;">
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-md-4"style="height:auto;padding-top:10px; ">
                                    <a href="<?= base_url();?>home?id=<?=$item; ?>">
                                        <?=$detail['item_name'].'<br><br>';?>
                                    </a>
                                    <br>
                                    <br> 
                                    <?php
									if(strlen($detail['item_text']) > 200){
										echo substr($detail['item_text'], 0, 200).'....'; 
									}else{
										echo substr($detail['item_text'], 0, 200); 
									}
									?>
                                </div>
                                <div class="col-md-4">
                                   <div class="row">
                                        <div class="col-md-7" style="height:200px;padding-top:20%;">
                                            <input type='number' id='<?= $item ?>' style="width:50px;border-radius:10px;" value="<?= $qty ?>" onchange='setcart("<?= $item ?>");'>
                                        </div>
                                        <div class="col-md-5" style="margin:-15px;height:200px;padding-top:20%;">
                                           <div> <br></div>
                                            <div>IDR <?= $subtotal;?></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <br>
                </div>
            <?php
            }
        }
        else{
        ?>
        <div class="col-md-3" style="height:200px;"></div>
            <div class="col-md-6" style="height:240px;">
                <center>
                   <img src="<?php echo base_url();?>img/empty cart.png" style="height:150px;"><br><br>
                    <span style="color:black;font-size:18pt;">UH OH! YOUR CART IS EMPTY
                    </span><br>
                    <span style="color:black;font-size:14pt;">Click <a href="http://localhost/unbuy/">here</a> to go back
                    </span>
                </center>
            
            </div>
            <div class="col-md-3" style="height:200px;"></div>
             
        <?php
        }}
        else{
            ?>
            <div class="col-md-3" style="height:200px;"></div>
            <div class="col-md-6" style="height:240px;">
                <center>
                   <img src="<?php echo base_url();?>img/empty cart.png" style="height:150px;"><br><br>
                    <span style="color:black;font-size:18pt;">UH OH! YOUR CART IS EMPTY
                    </span><br>
                    <span style="color:black;font-size:14pt;">Click <a href="http://localhost/unbuy/">here</a> to go back
                    </span>
                </center>
            
            </div>
            <div class="col-md-3" style="height:200px;"></div>
             
             
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-11" style="background-color:#ff6c60;height:4px;margin-left:3.5%;">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">TOTAL</div>
                            <div class="col-md-3">:</div>
                            <div class="col-md-5">IDR <?= $total; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <br>
        <div class="row" id="jkjkjkjk2">
            <div class="col-md-9"></div>
            <div class="col-md-3">
              <?php
            if(isset($_SESSION['cart'])){
               if(count($_SESSION['cart']) > 0){
                   ?>
                <input type="button" value="Proceed" class="btn-success" style="border-radius:25px;" onclick="cek_login_as_buyer();">
                <?php 
                    }
                else{
                ?>
                <input type="button" value="Proceed" style="border-radius:25px;">
                <?php
                }
                }
                else{
                ?>
                <input type="button" value="Proceed"  style="border-radius:25px;" disabled>
                <?php 
                } 
                ?>
                
            </div>
        </div>
    </section>
</section>