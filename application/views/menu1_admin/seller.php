<script type="text/javascript">
    
    var table;
    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>itemseller/ajax_list"
        });
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    function pilih(kode){
        window.location.href = "<?php echo base_url(); ?>itemseller/detil/"+kode;
    }
    
</script>
<section id="main-content">
        <section class="wrapper">
            <div class="row">
            <div class="col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        Data Seller
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
                </section>
            </div>
        </div>
        </section>
    </section>
