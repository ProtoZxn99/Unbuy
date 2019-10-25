<script type="text/javascript">
    
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>sellinghistory/ajax_list_history/<?php echo $kode_seller; ?>"
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
                        User Profile Seller
                    </header>
                    <div class="panel-body form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User Seller</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="User Seller" value="<?php echo $nama; ?>" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="User Address" value="<?php echo $alamat; ?>" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User Telephone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="User Telephone" value="<?php echo $tlp; ?>" readonly="">
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Data Selling History
                        </header>
                        <div class="panel-body">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Item Id</th>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Item Id</th>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                    </section>
                </div>
            </div>
        </section>
    </section>
