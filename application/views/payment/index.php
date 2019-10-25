<script type="text/javascript">
    
    function proses1(){
        var agree = document.getElementById('agree');
        if (agree.checked == true){
            var file_data = $('#file').prop('files')[0];
            var total = document.getElementById('total').value;
            
            var form_data = new FormData();            
            form_data.append('total', total);
            form_data.append('file', file_data);

            $.ajax({
                url: "<?php echo base_url(); ?>payment/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    if(response.status === 'Transaction save failed'){
                        alert(response.status);
                    }else{
                        proses2(response.status);
                    }
                    
                },error: function (response) {
                    alert(response.status);
                }
            });
        }else{
            alert("Please check our Terms and Conditions");
        }
    }
    
    function proses2(kode_trans){
        var agree = document.getElementById('agree');
        if (agree.checked == true){
            $.ajax({
                url : "<?php echo base_url(); ?>payment/proses1/"+kode_trans,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    alert(data.status);    
                    if(data.status === 'Transaction saved'){
                        window.location.href = "<?php echo base_url(); ?>payment/kembalihome";
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    alert("Error json " + errorThrown);
                }
            });
        }else{
            alert("Please check our Terms and Conditions");
        }
    }
    
</script>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="padding:15px;background-color:#ff6c60;color:white;border-radius:15px;">
                <img src="<?php echo base_url();?>img/card.png" style="height:60px;width:60px;margin-top:-20px;">
                <span style=" font-family:'times new roman'; font-size:28pt;margin-left:20px;">PAYMENT</span>
            </div>
            <div class="col-md-1"></div>
        </div>
         <br>
        <div class="row">
            <div class="col-md-11" style="background-color:#ff6c60;height:4px;margin-left:3.5%;"></div>
        </div>
        <br>
        <div class="row">
            <form id="form">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                       <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10"style="height:auto;" >
                            <center>
                                <br>
                                <input type="file" accept="image/*" onchange="loadFile(event)" id="file" name="file">
                                <img id="output" style="height: 200px; width: auto;"/>
                                <script>
                                  var loadFile = function(event) {
                                    var output = document.getElementById('output');
                                    output.src = URL.createObjectURL(event.target.files[0]);
                                  };
                                </script>
                                <br>
                            </center>
                            <input type="checkbox" name="agree" id="agree">&nbsp By checking this, you agree to be bound by, and to comply with, our <a> Terms and Conditions</a>
                            <br>
                            
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <div class="col-md-4" >
                   <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10" style="height:auto; border:3px solid #a9d86e;border-radius:17px;">
                            <div class="row">
                                <div class="col-md-12" style="padding:15px;background-color:#a9d86e;color:white;border-radius:15px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;">
                                    <img src="<?php echo base_url();?>img/receipt.png" style="height:60px;width:60px;margin-top:-20px;">
                                    <span style=" font-family:'times new roman'; font-size:28pt;margin-left:20px;">RECEIPT</span>
                                </div>
                            </div>
                            <br>
                            <?php
                            if(isset($_SESSION['cart'])){
                                $hasil = 0;
                                foreach ($_SESSION['cart'] as $item => $qty) {
                                    $qd = mysql_query("SELECT * FROM item where item_id = '".$item."';");
                                    $detail = mysql_fetch_assoc($qd);
                                    $subtotal = ($detail['item_price']*$qty);

                                    $hasil += $subtotal;
                                    ?>
                            <div class="row">
                                <div class="col-md-7"><?php echo $detail['item_price'].'  '.$detail['item_name']; ?></div>
                                <div class="col-md-5" style="text-align: right;">Rp. <?php echo $subtotal; ?></div>
                                <input type="hidden" name="item_id[]" value="<?php echo $item; ?>">
                                <input type="hidden" name="item_order[]" value="<?php echo $qty; ?>">
                                <input type="hidden" name="seller_id[]" value="<?php echo $detail['user_id']; ?>">
                            </div>
                            <br>
                                    <?php
                                }
                                ?>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-3">TOTAL</div>
                                <div class="col-md-5" style="text-align: right;">Rp. <?php echo $hasil; ?></div>
                                <input type="hidden" name="total" id="total" value="<?php echo $hasil; ?>">
                            </div>
                            <br>
                                <?php
                            }
                            ?>


                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </form>
            
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <center>
                    <br><br><br>
                    <input type="button" value="Proceed" class="btn btn-primary" onclick="proses1();">
                </center>
            </div>
        </div>
    </section>
</section>