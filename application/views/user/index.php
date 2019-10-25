<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>user/ajax_list"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function unblock(id){
        $.ajax({
            url : "<?php echo base_url(); ?>user/unblock/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                alert(data.status);    
                reload();
            },error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
            }
        });
    }
    
    function block(id){
        $.ajax({
            url : "<?php echo base_url(); ?>user/block/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                alert(data.status);    
                reload();
            },error: function (jqXHR, textStatus, errorThrown){
                alert("Error json " + errorThrown);
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
<!--                        Basic Table-->
                    </header>
                    <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>user id</th>
                                    <th>user name</th>
                                    <th>user email</th>
                                    <th>user birth</th>
                                    <th>user telephone</th>
                                    <th>user address</th>
                                    <th>user level</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>user id</th>
                                    <th>user name</th>
                                    <th>user email</th>
                                    <th>user birth</th>
                                    <th>user telephone</th>
                                    <th>user address</th>
                                    <th>user level</th>
                                    <th>action</th>
                                </tr>
                            </tfoot>
                        </table>
                </section>
            </div>
        </div>
        </section>
    </section>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_gambar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Slider</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Judul</label>
                            <div class="col-md-9">
                                <input type="text" name="judul" id="judul" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gambar</label>
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
</div>

<!-- Bootstrap modal keterangan -->
<div class="modal fade" id="modal_form_keterangan" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Form Keterangan Slider</h3>
            </div>
            <div class="modal-body form">
                <form id="form_keterangan" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Judul</label>
                            <div class="col-md-9">
                                <input type="text" name="judul" class="form-control" placeholder="Judul" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-9">
                                <input name="keterangan" class="form-control" type="text" placeholder="Keterangan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Ket Tambahan</label>
                            <div class="col-md-9">
                                <input name="ket_tambahan" class="form-control" type="text" placeholder="Keterangan Tambahan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Link Button</label>
                            <div class="col-md-9">
                                <select name="link_button" class="form-control">
                                    <option value="">- Pilih Link Button -</option>
                                    <?php
                                    $q_link = mysql_query("select idmenu, nama_menu from menu;");
                                    while ($row = mysql_fetch_array($q_link)) {
                                        ?>
                                    <option value="<?php echo $row['idmenu'] ?>"><?php echo $row['nama_menu']; ?></option>
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
                <button type="button" id="btnSave" onclick="saveketerangan();" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>