<script type="text/javascript">
    
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>buyinghistory/ajax_list_cust"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function pilih(kode){
        window.location.href = "<?php echo base_url(); ?>buyinghistory/detil/"+kode;
    }
    
</script>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    Customer
                </header>
                <div class="panel-heading">
                    <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>user id</th>
                                <th>user name</th>
                                <th>user email</th>
                                <th>user birth</th>
                                <th>user telephone</th>
                                <th>user address</th>
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
