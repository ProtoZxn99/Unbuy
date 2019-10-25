
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <?php
                  if($level == 2){
                      ?>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="icon-laptop"></i>
                          <span>Manage</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url(); ?>promo">Promotion</a></li>
                          <li><a  href="<?php echo base_url(); ?>category">Category</a></li>
                          <li><a  href="<?php echo base_url(); ?>user">User</a></li>
                          <li><a  href="<?php echo base_url(); ?>itemseller">Item</a></li>
                          <li><a  href="<?php echo base_url(); ?>transaction">Transaction</a></li>
                      </ul>
                  </li>
                    
                      <?php
                  }else if($level == 1){
                      ?>
                  <li class="sub-menu">
                      <a href="#">
                          <i class="icon-list"></i>
                          <span>Manage</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?= base_url(); ?>register_item">Item</a></li>
                      </ul>
                  </li>
                    <li class="sub-menu">
                      <a href="#" >
                          <i class="icon-dollar"></i>
                          <span>History</span>
                      </a>
                        <ul class="sub">
                          <li><a  href="<?= base_url(); ?>sellinghistory">Selling History</a></li>
                      </ul>
                  </li>
                      <?php
                  }else if($level == 0){
                      ?>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="icon-folder-close"></i>
                          <span>History</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?= base_url(); ?>buyinghistory">Buying History</a></li>
                      </ul>
                  </li>
                      <?php
                  }
                  ?>
                  
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->