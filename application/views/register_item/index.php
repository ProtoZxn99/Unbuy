<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>register_item/ajax_list"
        });        
        
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function add(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Register Item'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        var id = document.getElementById('id').value;
        var item_name = document.getElementById('item_name').value;
        var item_price = document.getElementById('item_price').value;
        var item_stock = document.getElementById('item_stock').value;
        var item_text = document.getElementById('item_text').value;
        var selectedValues = "";    
        $("#cat_id :selected").each(function(){
            selectedValues += $(this).val() + "~";
        });
    
        if(item_name === ''){
            alert('Please fill item name');
        }else if(item_price === ''){
            alert('Please fill item price');
        }else if(item_stock === ''){
            alert('Please fill item stock');
        
        }else{
            
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;

            if(save_method === 'add') {
                url = "<?php echo base_url(); ?>register_item/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>register_item/ajax_edit";
            }

            var file_data = $('#file').prop('files')[0];
        
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('item_name', item_name);
            form_data.append('item_price', item_price);
            form_data.append('item_stock', item_stock);
            form_data.append('item_text', item_text);
            form_data.append('cat_id', selectedValues);
            form_data.append('file', file_data);

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    $('#modal_form').modal('hide'); // show bootstrap modal
                    reload();
                    
                    // Enable
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button disable 
                },error: function (response) {
                    alert(response.status);
                }
            });
        }
    }
    
    function hapus(id){
        if(confirm("Do you want to delete this item with kode " + id + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>register_item/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                    alert(data.status);
                    reload();
                },
                error: function (jqXHR, textStatus, errorThrown){
                    alert('Error hapus data');
                }
            });
        }
    }
    
    function ganti(id){
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Update Register Item'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>register_item/detil/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.item_id);
                $('[name="item_name"]').val(data.item_name);
                $('[name="item_price"]').val(data.item_price);
                $('[name="item_stock"]').val(data.item_stock);
                $('[name="item_text"]').val(data.item_text);
            },error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }
    
</script>
<section id="main-content">
        <section class="wrapper">
            <div class="row">
            <div class="col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        Register Item
                    </header>
                    <div class="panel-heading">
                        <button class="btn btn-success" onclick="add();"><i class="glyphicon glyphicon-plus"></i> Add Item</button>
                        <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                    </div>
                    <div class="panel-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Prize</th>
                                    <th>Photo</th>
                                    <th>Stock</th>
                                    <th>Desc</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Prize</th>
                                    <th>Photo</th>
                                    <th>Stock</th>
                                    <th>Desc</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        </section>
    </section>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Register Item</h3>
            </div>
            <div class="modal-body form">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="id" id="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Item Name</label>
                            <div class="col-md-9">
                                <input type="text" name="item_name" id="item_name" class="form-control" placeholder="Item Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Item Price</label>
                            <div class="col-md-9">
                                <input type="text" name="item_price" id="item_price" class="form-control" placeholder="Item Price" onkeypress="return hanyaAngka(event, false)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Picture</label>
                            <div class="col-md-9">
                                <input id="file" name="file" class="form-control" type="file" placeholder="Input File">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Item Stock</label>
                            <div class="col-md-9">
                                <input type="text" name="item_stock" id="item_stock" class="form-control" placeholder="Item Stock" onkeypress="return hanyaAngka(event, false)">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Describe</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="item_text" id="item_text"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select multiple="" name="cat_id" id="cat_id" class="form-control">
                                    <?php
                                    $q_cat = mysql_query("SELECT cat_id, cat_name FROM category;");
                                    while ($row = mysql_fetch_array($q_cat)) {
                                        ?>
                                    <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save();" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>]