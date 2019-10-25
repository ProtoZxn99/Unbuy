<script type="text/javascript">
    
    $(document).ready(function() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true 
        });
    });
    
    function save(){
        $.ajax({
            url : "<?php echo base_url(); ?>profile/proses",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data){
                alert(data.status);
            },error: function (jqXHR, textStatus, errorThrown){
                alert('Error get data');
            }
        });
    }
    
    function addfoto(){
        $('#form_foto')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
    }
    
    function simpangambar(){
        $('#btnSaveGambar').text('Saving...'); //change button text
        $('#btnSaveGambar').attr('disabled',true); //set button disable 

        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $.ajax({
            url: "<?php echo base_url(); ?>profile/simpangambar",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);
                
                // Enable
                $('#btnSaveGambar').text('Save'); //change button text
                $('#btnSaveGambar').attr('disabled',false); //set button disable 
                
                $('#modal_form').modal('hide'); // show bootstrap modal
                
                if(response.status === 'Image uploaded'){
                    window.location.href = "<?php echo base_url(); ?>";
                }
            },error: function (response) {
                alert(response.status);
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
                        User Profile
                    </header>
                    <div class="panel-body form-horizontal">
                        <form id="form">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input name="username" type="text" class="form-control" placeholder="Username" value="<?php echo $nama; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">User Email</label>
                                <div class="col-sm-10">
                                    <input name="user_email" type="text" class="form-control" placeholder="User Email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Birth Date</label>
                                <div class="col-sm-10">
                                    <input name="birth_date" type="text" class="form-control datepicker" placeholder="Birth Date" value="<?php echo $tgllahir; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">User Telephone</label>
                                <div class="col-sm-10">
                                    <input name="user_telephone" type="text" class="form-control" placeholder="User Telephone" value="<?php echo $tlp; ?>" onkeypress="return hanyaAngka(event,false);">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">User Address</label>
                                <div class="col-sm-10">
                                    <input name="user_address" type="text" class="form-control" placeholder="User Address" value="<?php echo $alamat; ?>">
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-sm-2 control-label">User Bank</label>
                                <div class="col-sm-10">
                                    <input name="user_bank" type="text" class="form-control" placeholder="User Bank" value="<?php echo $bank; ?>">
                                </div>
                            </div>-->
                        </form>
                        <div class="form-group">
                            <label class="control-label col-md-2">Photo Picture</label>
                            <div class="col-md-10">
                                <button class="btn btn-primary" onclick="addfoto();"><i class="glyphicon glyphicon-picture"></i> Upload Foto </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-success" onclick="save();"><i class="glyphicon glyphicon-plus"></i> Save</button>
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
                <h3 class="modal-title">Form Photo Picture</h3>
            </div>
            <div class="modal-body form">
                <form id="form_foto" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Photo Picture</label>
                            <div class="col-md-8">
                                <input id="file" name="file" class="form-control" type="file" placeholder="Input Foto">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveGambar" onclick="simpangambar();" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>