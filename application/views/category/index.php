<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>category/ajax_list"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function add(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Category'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        var nama = document.getElementById('cat_name').value;
        if(nama === ''){
            alert('Please fill in all fields');
        }else{
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            
            var url;
            if(save_method === 'add') {
                url = "<?php echo base_url(); ?>category/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>category/ajax_edit";
            }

            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    alert(data.status);    
                    reload();
                    $('#modal_form').modal('hide');
                    
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button disable 
                },error: function (jqXHR, textStatus, errorThrown){
                    alert("Error json " + errorThrown);
                }
            });
        }
    }
    
    function hapus(id){
        if(confirm("Do you want to delete this category with code " + id + " ?")){
            // ajax delete data to database
            $.ajax({
                url : "<?php echo base_url(); ?>category/hapus/" + id,
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
        $('#modal_form').modal('show');
        $('.modal-title').text('Edit Category'); // Set Title to Bootstrap modal title
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>category/detil/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.cat_id);
                $('[name="cat_name"]').val(data.cat_name);
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
                    Category
                </header>
                <div class="panel-heading">
                    <button class="btn btn-success" onclick="add();"><i class="glyphicon glyphicon-plus"></i> Add Category</button>
                    <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
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
                <h3 class="modal-title">Form Category</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Category Name</label>
                            <div class="col-md-9">
                                <input id="cat_name" name="cat_name" class="form-control" type="text" placeholder="Category Name">
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
</div>