<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>transaction/ajax_list"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function confirm(id){
        $.ajax({
            url : "<?php echo base_url(); ?>transaction/setuju/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                alert(data.status);
                reload();
                if(data.status === 'Confirm success'){
                    window.location.href = "<?php  echo base_url(); ?>transaction";
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error hapus data');
            }
        });
    }
    
    function unconfirm(id){
        $.ajax({
            url : "<?php echo base_url(); ?>transaction/tidaksetuju/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                alert(data.status);
                reload();
                if(data.status === 'Unconfirm success'){
                    window.location.href = "<?php  echo base_url(); ?>transaction";
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error hapus data');
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
                    Transaction
                </header>
                <div class="panel-heading">
                    <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Trans Id</th>
                                <th>Trans Receipt</th>
                                <th>Trans Status</th>
                                <th>Buyer Id</th>
                                <th>Trans Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Trans Id</th>
                                <th>Trans Receipt</th>
                                <th>Trans Status</th>
                                <th>Buyer Id</th>
                                <th>Trans Date</th>
                                <th>Total</th>
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