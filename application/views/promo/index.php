<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>promo/ajax_list"
        });        
        
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function add(){
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Promotion'); // Set Title to Bootstrap modal title
    }
    
    function save(){
        var information = document.getElementById('information').value;
        if(information === ''){
            alert('Please fill the blank');
        }else{
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;

            if(save_method === 'add') {
                url = "<?php echo base_url(); ?>promo/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>promo/ajax_edit";
            }

            var id = document.getElementById('id').value;
            var keterangan = document.getElementById('information').value;
            var file_data = $('#file').prop('files')[0];
        
            var form_data = new FormData();
            form_data.append('id', id);
            form_data.append('promo_name', keterangan);
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
                url : "<?php echo base_url(); ?>promo/hapus/" + id,
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
        $('.modal-title').text('Update Promotion'); // Set title to Bootstrap modal title
        
        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo base_url(); ?>promo/detil/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                $('[name="id"]').val(data.promo_id);
                $('[name="information"]').val(data.promo_name);
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
                        Promotion
                    </header>
                    <div class="panel-heading">
                        <button class="btn btn-success" onclick="add();"><i class="glyphicon glyphicon-plus"></i> Add Promotion</button>
                        <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                    </div>
                    <div class="panel-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Promo id</th>
                                    <th>Picture</th>
                                    <th>Information</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Promo id</th>
                                    <th>Picture</th>
                                    <th>Information</th>
                                    <th>action</th>
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
                <h3 class="modal-title">Form Promotion</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" name="id" id="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Information</label>
                            <div class="col-md-9">
                                <input type="text" name="information" id="information" class="form-control" placeholder="Information">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Picture</label>
                            <div class="col-md-9">
                                <input id="file" name="file" class="form-control" type="file" placeholder="Input File">
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