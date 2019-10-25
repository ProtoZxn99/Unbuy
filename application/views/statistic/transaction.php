<script type="text/javascript">
    
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#example').DataTable( {
            "ajax": "<?php echo base_url() ?>trans/ajax_list",
            "order": [[ 4, "desc" ]]
        });        
    });
    
    function reload(){
        table.ajax.reload(null,false); //reload datatable ajax
    }
    
    
</script>
<section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="row state-overview">
                  
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $jml_user; ?>
                              </h1>
                              <p>Users</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="icon-tags"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $nama_user; ?>
                              </h1>
                              <p>Pembeli Loyal</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="icon-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1 style="font-size: 22px;">
                                  <?php echo $penjual; ?>
                              </h1>
                              <p>Best Seller</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="icon-bar-chart"></i>
                          </div>
                          <div class="value">
                              <h1>
                                  <?php echo $jml_trans; ?>
                              </h1>
                              <p>total Transactions</p>
                          </div>
                      </section>
                  </div>
              </div>
                </div>
            </div>
            <div class="row">
            <div class="col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
<!--                        Basic Table-->
                    </header>
                    <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Trans Receipt</th>
                                    <th>Trans Status</th>
                                    <th>Buyer Name</th>
                                    <th>Trans Date</th>
                                    <th>Trans Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Trans Receipt</th>
                                    <th>Trans Status</th>
                                    <th>Buyer Name</th>
                                    <th>Trans Date</th>
                                    <th>Trans Total</th>
                                </tr>
                            </tfoot>
                        </table>
                </section>
            </div>
        </div>
        </section>
    </section>
