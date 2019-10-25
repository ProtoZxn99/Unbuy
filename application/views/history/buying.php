<script type="text/javascript">
    
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>buyinghistory/ajax_list"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
</script>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    Buying history
                </header>
                <div class="panel-heading">
                    <button class="btn btn-default" onclick="reload();"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                </div>
                <div class="panel-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Trans Receipt</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Trans Receipt</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </div>
    </section>
</section>
